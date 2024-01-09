<?php

namespace AppKit\UI;

use BadMethodCallException;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\View\ComponentAttributeBag;
use InvalidArgumentException;
use ReflectionMethod;
use RuntimeException;

class AttributeBuilder
{
    use ForwardsCalls;

    /**
     * An array to store the registered attribute helpers
     * @var array
     */
    protected static $attributeHelpers = [];

    /**
     * An array to store the registered conditional helpers
     * @var array<string,closure>
     */
    protected $states = [];

    /**
     * An array of attribute bags for each of the registered elements
     * @var array<string,ComponentAttributeBag>
     */
    protected $elementAttributeBags = [];

    /**
     * The class list for the main element
     * @var ClassList
     */
    protected ClassList $classList;

    /**
     * An array of class list for each of the registered elements
     * @var array<string,ClassList>
     */
    protected $elementClassLists = [];

    public function __construct(
        protected ComponentAttributeBag &$attributeBag,
        array $elements = []
    ) {
        // create a class list for the default element
        $this->classList = new ClassList($this);

        // loop through each of the elements that have been specified
        foreach ($elements as $element) {
            // create a new attribute bag for that element
            $this->elementAttributeBags[$element] = new ComponentAttributeBag();

            // create a class list for the element
            $this->elementClassLists[$element] = new ClassList($this, $element);

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
                    $this->getAttributeBag($element)->offsetSet($newAttributeName, $value);

                    // and remove it from the default attribute bag (which will still have the old name)
                    $this->getAttributeBag()->offsetUnset($attributeName);
                }
            }
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
     * Add classes to the attribute bag
     *
     * @param mixed $classes
     * @return AttributeBuilder
     * @throws InvalidArgumentException
     */
    public function addClass($classes, $condition = null, $negateCondition = false, $element = null, $state = null): AttributeBuilder
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($classes) && $state) {
            // get the value of the state
            $stateValue = $this->states[$state]();

            // we need to get the value from the array
            $classes = array_key_exists($stateValue, $classes) ? $classes[$stateValue] : null;
        } else {
            // flatten the arguments into the function
            $classes = Arr::flatten(Arr::wrap($classes));
        }

        // add the class to the class list
        $this->classList->add($classes);

        // return a fluent api
        return $this;
    }

    /**
     * Remove classes from the attribute bag
     *
     * @param mixed $classes
     * @return AttributeBuilder
     */
    public function removeClass($classes, $condition = null, $negateCondition = false, $element = null, $state = null): AttributeBuilder
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($classes) && $state) {
            // get the value of the state
            $stateValue = $this->states[$state]();

            // we need to get the value from the array
            $classes = array_key_exists($stateValue, $classes) ? $classes[$stateValue] : null;
        } else {
            // flatten the arguments into the function
            $classes = Arr::flatten((array) $classes);
        }

        // remove the class from the class list
        $this->classList->remove($classes);

        // return a fluent api
        return $this;
    }

    /**
     * Set an attribute on the attribute bag
     *
     * @param mixed $attribute
     * @param mixed $value
     * @param mixed $condition
     * @param bool $negateCondition
     * @return AttributeBuilder
     * @throws RuntimeException
     */
    public function setAttribute($attribute, $value = null, $attributeType = null, $condition = null, $negateCondition = false, $element = null, $state = null): AttributeBuilder
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($value)) {
            // and have a state element
            if ($state) {
                // get the value of the state
                $stateValue = $this->states[$state]();

                // we need to get the value from the array
                $value = array_key_exists($stateValue, $value) ? $value[$stateValue] : null;
            }
        }

        // loop through each of the attributes that we need to remove
        foreach ($this->formatAttributes([$attribute => $value], $attributeType) as $attribute => $value) {
            $this->getAttributeBag($element)->offsetSet($attribute, $value);
        }

        // return a fluent API
        return $this;
    }

    /**
     * Remove an attribute from the attribute bag
     *
     * @param mixed $attribute
     * @param mixed $attributeType
     * @param mixed $condition
     * @param bool $negateCondition
     * @return AttributeBuilder
     * @throws RuntimeException
     */
    public function removeAttribute($attribute, $attributeType = null, $condition = null, $negateCondition = false, $element = null): AttributeBuilder
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // make sure that the attributes are an array
        $attribute = (array) $attribute;

        // and then fill them with null
        $attribute = array_fill_keys($attribute, null);

        // loop through each of the attributes that we need to remove
        foreach ($this->formatAttributes($attribute, $attributeType) as $attribute => $value) {
            // and remove it
            $this->getAttributeBag($element)->offsetUnset($attribute);
        }

        // return a fluent API
        return $this;
    }

    /**
     * Get an attribute from the attribute bag
     *
     * @param mixed $attribute
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($attribute, $default = null, $element = null): mixed
    {
        // get the attribute from the attribute bag
        return $this->getAttributeBag($element)->get($attribute, $default);
    }

    public function when($condition, Closure $callback, bool $negateCondition = false)
    {
        if ($this->conditionalPasses($condition, $negateCondition)) {
            $callback($this);
        }

        return $this;
    }

    public function whenNot($condition, Closure $callback)
    {
        return $this->when($condition, $callback, true);
    }

    public function if($condition, Closure $callback, bool $negateCondition = false)
    {
        return $this->when($condition, $callback, $negateCondition);
    }

    public function ifNot($condition, Closure $callback)
    {
        return $this->when($condition, $callback, true);
    }

    /**
     * Apply mixins to the attribute builder
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
     * @return AttributeBuilder
     * @throws InvalidArgumentException
     */
    public function mergeAttributes($attributes): AttributeBuilder
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
    protected function formatAttributes($attributes, $attributeType = null): array
    {
        // ensure that the attributes are an array (it's possible only one has been passed)
        $attributes = (array) $attributes;

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
    protected function conditionalPasses(string|callable $condition, bool $negateCondition): bool
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
     * @return AttributeBuilder
     */
    public function registerState(string $name, callable $callable): AttributeBuilder
    {
        $this->states[$name] = $callable;

        return $this;
    }

    /**
     * Return the underlying component attribute bag instance
     *
     * @return ComponentAttributeBag
     */
    public function getAttributeBag(?string $element = null): ComponentAttributeBag
    {
        if ($element) {
            return $this->elementAttributeBags[$element];
        }

        return $this->attributeBag;
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
        ' . $this->generateMagicMethodRegexCapture('element', $this->elementAttributeBags, ['to', 'on', 'from']) . '
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
            $magicMethodParameterNames = ['attribute', 'value', 'attributeType', 'condition', 'negateCondition', 'element'];

            // we alias the add operation to set when dealing with attributes
            if ($magicMethodRegexMatches['operation'] == 'add' && $magicMethodRegexMatches['type'] == 'Attribute') {
                $magicMethodRegexMatches['operation'] = 'set';
            }

            // if we are dealing with classes
            if ($magicMethodRegexMatches['type'] == 'Class') {
                // we don't have an attribute or value element, so we remove them
                array_splice($magicMethodParameterNames, 0, 2);

                // and replace them with classes at the start
                $magicMethodParameterNames = ['classes'] + $magicMethodParameterNames;
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
                $methodReflection = new ReflectionMethod($this, $methodName);

                // get the parameters of that method
                $methodParametersReflection = $methodReflection->getParameters();

                // create an array to store the parameters that we will actually pass to the method
                $methodParameterValues = [];

                foreach ($methodParametersReflection as $callableParameter) {
                    // get the name of the parameter
                    $parameterName = $callableParameter->getName();

                    // check if we have a matching parameter in the regex matches
                    if (array_key_exists($parameterName, $magicMethodRegexMatches) && !empty($magicMethodRegexMatches[$parameterName])) {
                        // if we do, we get that value and set it on the array that will be passed to the method
                        $methodParameterValues[$parameterName] = lcfirst($magicMethodRegexMatches[$parameterName]);

                        // we then remove the parameter name from the list that we are still looking for
                        $magicMethodParameterNames = array_diff($magicMethodParameterNames, [$parameterName]);
                    }
                }

                // because we have removed some things from the array, we want to reset the keys
                $magicMethodParameterNames = array_values($magicMethodParameterNames);

                // loop through everything that is left
                foreach ($magicMethodParameterNames as $parameterPosition => $parameterName) {
                    // and check if it was passed through as a parameter to the magic method
                    if (isset($parameters[$parameterPosition])) {
                        // if it was, then we add it to the list of parameters
                        $methodParameterValues[$parameterName] = $parameters[$parameterPosition];
                    }
                }

                // finally, we call the underlying method
                return call_user_func_array([$this, $methodName], $methodParameterValues);
            }
        }

        return $this->forwardCallTo($this->attributeBag, $method, $parameters);
    }
}
