<?php

namespace AppKit\UI;

use ArrayAccess;
use BadMethodCallException;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\View\ComponentAttributeBag;
use InvalidArgumentException;
use ReflectionMethod;
use RuntimeException;

class ComponentBuilder implements ArrayAccess
{
    use ForwardsCalls;

    /**
     * An array to store the registered attribute helpers
     * @var array
     */
    public static $attributeHelpers = [];

    /**
     * An array to store the registered conditional helpers
     * @var array<string,closure>
     */
    public $states = [];

    /**
     * An array of elements, including the default one
     * @var Element[]
     */
    public $elements;

    public function __construct(
        protected ComponentAttributeBag &$attributeBag,
        array $elements = []
    ) {
        // set up the default element
        $this->elements['__default'] = new Element($this, $attributeBag);

        // loop through each of the elements that have been specified
        foreach ($elements as $element) {
            // create a new attribute bag for that element
            $elementAttributeBag = new ComponentAttributeBag();

            // generate the element prefix
            $elementPrefix = Str::of($element . ':')->kebab()->__toString();

            // loop through all of the attributes that we have in the attribute bag
            foreach ($attributeBag->getAttributes() as $attributeName => $value) {
                // get an instance of a String for the attribute name
                $attributeString = Str::of($attributeName);

                // check if the attribute name starts with the prefix
                if ($attributeString->startsWith($elementPrefix)) {
                    // get the new name of the attribute, without the prefix
                    $newAttributeName = $attributeString->remove($elementPrefix)->__toString();

                    // add the attribute to the appropriate element attribute bag
                    $elementAttributeBag->offsetSet($newAttributeName, $value);

                    // and remove it from the default attribute bag (which will still have the old name)
                    $this->getAttributeBag()->offsetUnset($attributeName);
                }
            }

            // create an Element instance, and store it in the elements array, indexed by the name of the element
            $this->elements[$element] = new Element($this, $elementAttributeBag);
        }
    }

    /**
     * Register a new attribute helper
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public static function registerAttributeHelper(string $name, callable $callback): void
    {
        self::$attributeHelpers[$name] = $callback;
    }

    /**
     * Conditionally run updates on the component
     *
     * @param mixed $condition
     * @param Closure $callback
     * @param bool $negateCondition
     * @return $this
     */
    public function when($condition, Closure $callback, bool $negateCondition = false)
    {
        if ($this->conditionalPasses($condition, $negateCondition)) {
            $callback($this);
        }

        return $this;
    }

    /**
     * (Inverse) Conditionally run updates on the component
     *
     * @param mixed $condition
     * @param Closure $callback
     * @return $this
     */
    public function whenNot($condition, Closure $callback)
    {
        return $this->when($condition, $callback, true);
    }

    /**
     * Conditionally run updates on the component
     *
     * @param mixed $condition
     * @param Closure $callback
     * @param bool $negateCondition
     * @return $this
     */
    public function if($condition, Closure $callback, bool $negateCondition = false)
    {
        return $this->when($condition, $callback, $negateCondition);
    }

    /**
     * (Inverse) Conditionally run updates on the component
     *
     * @param mixed $condition
     * @param Closure $callback
     * @return $this
     */
    public function ifNot($condition, Closure $callback)
    {
        return $this->when($condition, $callback, true);
    }

    /**
     * Apply mixins to the component builder
     *
     * @param mixed $mixins
     * @return $this
     */
    public function mixin(...$mixins)
    {
        // turn the mixins into a nice array
        $mixins = Arr::flatten($mixins);

        // loop through the mixins
        foreach ($mixins as $mixin) {
            // if it's a class name, we need to get an instance of it
            if (is_string($mixin) && class_exists($mixin) && method_exists($mixin, '__invoke')) {
                $mixin = new $mixin();
            }

            // call the mixin
            $mixin($this);
        }

        // return a fluent API
        return $this;
    }

    /**
     * Merge the attributes into the attribute bag
     *
     * @param mixed $attributes
     * @return ComponentBuilder
     * @throws InvalidArgumentException
     */
    public function mergeAttributes($attributes): ComponentBuilder
    {
        // merge on the attribute bag will return a new instance, so we need to update our reference to be the new one
        $this->attributeBag = $this->attributeBag->merge($attributes);

        // return a fluent API
        return $this;
    }

    /**
     * Format attributes, optionally passing them through an attribute helper
     *
     * @param array $attributes
     * @param string $attributeType
     * @return array
     */
    public function formatAttributes($attributes, $attributeType = null): array
    {
        // ensure that the attributes are an array (it's possible only one has been passed)
        $attributes = Arr::wrap($attributes);

        // if we don't have an attribute type
        if ($attributeType == null) {
            // then we just return the attributes as they are
            return $attributes;
        } elseif (!array_key_exists($attributeType, self::$attributeHelpers)) {
            // if we don't have a matching helper, then throw an exception
            throw new RuntimeException('No such attribute helper ' . $attributeType);
        }

        // an array to store the formatted attributes
        $formattedAttributes = [];

        // loop through all of the attributes
        foreach ($attributes as $attribute => $value) {
            // if we do, we need to pass it through the callback
            $attributeHelperResults = self::$attributeHelpers[$attributeType]($attribute, $value);

            // merge in the result of the helper, it's possible the helper sets multiple attributes
            $formattedAttributes = $formattedAttributes + $attributeHelperResults;
        }

        // return the formatted attributes
        return $formattedAttributes;
    }

    /**
     * Check that a conditional helper passes
     *
     * @param string|callable $condition
     * @param bool $negateCondition
     * @return bool
     */
    public function conditionalPasses(string|callable $condition, bool $negateCondition): bool
    {
        // check if we have a condition that exists in the helpers
        if (is_string($condition)) {
            $condition = $this->states[$condition];
        }

        // evaluate the conditional, ensuring that it's a boolean
        $conditionResult = $condition() === true;

        // negate the result of the conditional if we need to
        if ($negateCondition) {
            $conditionResult = !$conditionResult;
        }

        return $conditionResult;
    }

    /**
     * Register a state
     *
     * @param string $name
     * @param callable $callable
     * @return ComponentBuilder
     */
    public function registerState(string $name, callable $callable): ComponentBuilder
    {
        $this->states[$name] = $callable;

        return $this;
    }

    /**
     * Return the underlying component attribute bag instance
     *
     * @return ComponentAttributeBag
     */
    public function getAttributeBag(?string $element = '__default'): ComponentAttributeBag
    {
        return $this->element($element)->getAttributeBag();
    }

    /**
     * Return the value of the component state
     *
     * @param mixed $state
     * @return mixed
     */
    public function getStateValue($state)
    {
        // check if we have a condition that exists in the helpers
        if (is_string($state)) {
            $state = $this->states[$state];
        }

        // evaluate the conditional, ensuring that it's a boolean
        return $state();
    }

    /**
     * Return a given element
     *
     * @param string $element
     * @return Element
     */
    public function element($element = '__default'): Element
    {
        return $this->elements[$element];
    }

    /**
     * Get the attributes, of the default element
     *
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->element()->getAttributes();
    }

     /**
     * Get an attribute value on the default element via magic parameter
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->element()->__get($name);
    }

    /**
     * Set an attribute value on the default element via magic parameter
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->element()->__set($name, $value);
    }

    /**
     * Unset an attribute value on the default element via a magic parameter
     *
     * @param string $name
     * @return void
     */
    public function __unset(string $name): void
    {
        $this->element()->__unset($name);
    }

    /**
     * Set an attribute on the default element via array notation
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->element()->offsetSet($offset, $value);
    }

    /**
     * Get an attribute on the default element via array notation
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->element()->offsetGet($offset);
    }

    /**
     * Check if an attribute exists via array notation
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->element()->offsetExists($offset);
    }

    /**
     * Remove an attribute on the default element via array notation
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->element()->offsetUnset($offset);
    }

    private function generateMagicMethodRegexCapture(string $captureGroup, array $values, array $triggers = [])
    {
        // we need to build up the regex that we are going to use to parse the method
        $regexString = '';
        $triggerString = '';

        // check if we have any attribute helpers
        if (!empty($values)) {
            // create an array to store all of the helper names
            $regexValues = [];

            foreach (array_keys($values) as $value) {
                // pull out the name of the helper in studly case
                $regexValues[] = Str::of($value)->studly()->__toString();
            }

            if (!empty($triggers)) {
                // create an array to store all of the helper names
                $triggerValues = [];

                foreach ($triggers as $trigger) {
                    // pull out the name of the helper in studly case
                    $triggerValues[] = Str::of($trigger)->studly()->__toString();
                }

                $triggerString = '(' . implode('|', $triggerValues) . ')';
            }

            // create the string that will be included in the regex
            $regexString = '(' . $triggerString . '(?P<' . $captureGroup . '>' . implode('|', $regexValues) . '))?';
        }

        return $regexString;
    }

    /**
     * Magic method to catch everything that we aren't already dealing with
     *
     * @param mixed $method
     * @param mixed $parameters
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        // create the regex
        $magicMethodRegex = '
        /
        (?P<operation>set|add|remove|toggle)
        ' . $this->generateMagicMethodRegexCapture('attributeType', self::$attributeHelpers) . '
        (?P<attribute>[A-Za-z0-9]*)?
        (?P<type>Attribute|Class)
        ' . $this->generateMagicMethodRegexCapture('element', $this->elements, ['to', 'on', 'from']) . '
        ' . $this->generateMagicMethodRegexCapture('state', $this->states, ['for']) . '
        (
            (If|When)
            (?P<negateCondition>Not)?
            (?P<condition>[A-Za-z0-9]*)
        )?
        /x
        ';

        // an array to store any possible matches from the magic method regex
        $magicMethodRegexMatches = [];

        if (preg_match($magicMethodRegex, $method, $magicMethodRegexMatches)) {
            // we alias the add operation to set when dealing with attributes
            if ($magicMethodRegexMatches['operation'] == 'add' && $magicMethodRegexMatches['type'] == 'Attribute') {
                $magicMethodRegexMatches['operation'] = 'set';
            }

            // calculate the name of the method that we actually want to call
            $methodName = $magicMethodRegexMatches['operation'] . $magicMethodRegexMatches['type'];

            // the methods that we are allowed to call via the magic method
            $allowedMethods = [
                'addClass',
                'removeAttribute',
                'removeClass',
                'setAttribute',
            ];

            // check that it is an allowed method
            if (in_array($methodName, $allowedMethods)) {
                // get the reflection of the method that we are ultimately going to call
                $methodReflection = new ReflectionMethod($this->element(), $methodName);

                // get the parameters of that method
                $methodParametersReflection = $methodReflection->getParameters();

                // create an array to store the parameters that we will actually pass to the method
                $methodParameterValues = [];

                // an array that will store the name of the arguments that haven't been passed in the name of the function, or a name parameter
                $remainingParameters = [];

                foreach ($methodParametersReflection as $callableParameter) {
                    // get the name of the parameter
                    $parameterName = $callableParameter->getName();

                    // check if we have the parameter in the method name
                    if (array_key_exists($parameterName, $magicMethodRegexMatches) && !empty($magicMethodRegexMatches[$parameterName])) {
                        // if we do, we get that value and set it on the array that will be passed to the method
                        $methodParameterValues[$parameterName] = lcfirst($magicMethodRegexMatches[$parameterName]);
                    } elseif (array_key_exists($parameterName, $parameters)) {
                        // if we do, we get that value and set it on the array that will be passed to the method
                        $methodParameterValues[$parameterName] = $parameters[$parameterName];

                        // remove this as a parameter, as we have already used it
                        unset($parameters[$parameterName]);
                    } else {
                        // we don't seem to have this parameter, keep a note of that
                        $remainingParameters[] = $parameterName;
                    }
                }

                // as we have been removing from the parameters, we need to reindex the array
                $parameters = array_values($parameters);

                // loop through the parameters that we had passed into the method
                foreach ($parameters as $i => $remainingParameter) {
                    // check if we have a possible value in the remaining parameters array
                    if (array_key_exists($i, $remainingParameters)) {
                        // if we do, we will use that as the parameter value
                        $methodParameterValues[$remainingParameters[$i]] = $remainingParameter;
                    }
                }

                // get the element that we are running this one
                $element = (!empty($magicMethodRegexMatches['element']) ? lcfirst($magicMethodRegexMatches['element']) : '__default');

                // finally, we call the underlying method
                call_user_func_array([$this->element($element), $methodName], $methodParameterValues);

                // return a fluent API
                return $this;
            }
        }

        // forward any remaining calls to the underlying, default, element
        $this->forwardCallTo($this->element(), $method, $parameters);

        // return a fluent API
        return $this;
    }
}
