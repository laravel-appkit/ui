<?php

namespace AppKit\UI;

use BadMethodCallException;
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
    protected $conditionalHelpers = [];

    /**
     * An array of attribute bags for each of the registered elements
     * @var array<string,ComponentAttributeBag>
     */
    protected $elementAttributeBags = [];

    public function __construct(
        protected ComponentAttributeBag &$attributeBag,
        protected Collection $options,
        array $elements = []
    ) {
        // loop through each of the elements that have been specified
        foreach ($elements as $element) {
            // create a new attribute bag for that element
            $this->elementAttributeBags[$element] = new ComponentAttributeBag();

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
    public function addClass(...$classes): AttributeBuilder
    {
        // flatten the arguments into the function
        $classes = Arr::flatten($classes);

        // merge the new classes with the existing ones
        $this->mergeAttributes(['class' => implode(' ', $classes)]);

        // return a fluent API
        return $this;
    }

    /**
     * Remove classes from the attribute bag
     *
     * @param mixed $classes
     * @return AttributeBuilder
     */
    public function removeClass(...$classes): AttributeBuilder
    {
        // flatten the arguments to the function
        $classes = Arr::flatten($classes);

        // calculate the classes that we need to remove
        $classesToRemove = collect($classes)
            ->map(function ($item) {
                // covert every item into an array
                if (is_array($item)) {
                    // if we are already an array, we can just return it
                    return $item;
                }

                // otherwise, we need to split the string on spaces
                return explode(' ', $item);
            })
            ->flatten()
            ->map(function ($item) {
                // trim all of the items in the collection
                return trim($item);
            })
            ->toArray();

        // get all of the current classes already applied
        $currentClasses = explode(' ', $this->getAttribute('class'));

        // create an array to store all of the new classes
        $newClasses = [];

        // loop through all of the classes that we already have
        foreach ($currentClasses as $currentClass) {
            // trim the class
            $currentClass = trim($currentClass);

            // check if it's in the list of classes to remove
            if (!in_array($currentClass, $classesToRemove)) {
                // if it's not, we add it to the list of classes that the attribute bag should have
                $newClasses[] = $currentClass;
            }
        }

        // set the class attribute
        $this->setAttribute('class', implode(' ', $newClasses));

        // return a fluent API
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
    public function setAttribute($attribute, $value = null, $attributeType = null, $condition = null, $negateCondition = false, $element = null): AttributeBuilder
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->conditionalPasses($condition, $negateCondition)) {
            return $this;
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
    public function getAttribute($attribute, $default = null): mixed
    {
        // get the attribute from the attribute bag
        return $this->get($attribute, $default);
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
            $condition = $this->conditionalHelpers[$condition];
        }

        // evaluate the conditional
        $conditionResult = $condition();

        // negate the result of the conditional if we need to
        if ($negateCondition) {
            $conditionResult = !$conditionResult;
        }

        return $conditionResult;
    }

    /**
     * Register a conditional
     *
     * @param string $name
     * @param callable $callable
     * @return AttributeBuilder
     */
    public function registerConditional(string $name, callable $callable): AttributeBuilder
    {
        $this->conditionalHelpers[$name] = $callable;

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
     * Magic method to catch everything that we aren't already dealing with
     *
     * @param mixed $method
     * @param mixed $parameters
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        // we need to build up the regex that we are going to use to parse the method
        $attributeTypesString = '';

        // check if we have any attribute helpers
        if (!empty(self::$attributeHelpers)) {
            // create an array to store all of the helper names
            $attributeTypes = [];

            foreach (self::$attributeHelpers as $helper => $closure) {
                // pull out the name of the helper in studly case
                $attributeTypes[] = Str::of($helper)->studly()->__toString();
            }

            // create the string that will be included in the regex
            $attributeTypesString = '(?P<attributeType>' . implode('|', $attributeTypes) . ')?';
        }

        // we also need to build up the regex that we are going to use for the element
        $attributeBagString = '';

        // if we have any element attribute bags
        if (!empty($this->elementAttributeBags)) {
            // create an array to store all of the names
            $elementAttributeBags = [];

            foreach ($this->elementAttributeBags as $name => $elementAttributeBag) {
                // pull out each of the element names in study case
                $elementAttributeBags[] = Str::of($name)->studly()->__toString();
            }

            // create the string that will be used in the regex
            $attributeBagString = '((To|On|From)(?P<element>' . implode('|', $elementAttributeBags) . '))?';
        }

        // create the regex
        $magicMethodRegex = '
        /
        (?P<operation>set|add|remove|toggle)
        ' . $attributeTypesString . '
        (?P<attribute>[A-Za-z0-9]*)?
        (?P<type>Attribute|Class)
        ' . $attributeBagString . '
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

            // we alias the add operation to set
            if ($magicMethodRegexMatches['operation'] == 'add') {
                $magicMethodRegexMatches['operation'] = 'set';
            }

            // calculate the name of the method that we actually want to call
            $methodName = $magicMethodRegexMatches['operation'] . $magicMethodRegexMatches['type'];

            // the methods that we are allowed to call via the magic method
            $allowedMethods = [
                'setAttribute',
                'removeAttribute',
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
