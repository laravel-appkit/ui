<?php

namespace AppKit\UI;

use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\View\ComponentAttributeBag;

class Element
{
    use ForwardsCalls;

    /**
     * The class list for this element
     * @var ClassList
     */
    protected ClassList $classList;

    public function __construct(protected AttributeBuilder $attributeBuilder, protected ComponentAttributeBag $attributeBag)
    {
        // create the class list for this element
        $this->classList = new ClassList($attributeBuilder, $this);
    }

    /**
     * Add classes to the attribute bag
     *
     * @param mixed $classes
     * @return AttributeBuilder
     * @throws InvalidArgumentException
     */
    public function addClass($classes, $condition = null, $negateCondition = false, $state = null): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->attributeBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($classes) && $state) {
            // get the value of the state
            $stateValue = $this->attributeBuilder->states[$state]();

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
    public function removeClass($classes, $condition = null, $negateCondition = false, $state = null): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->attributeBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($classes) && $state) {
            // get the value of the state
            $stateValue = $this->attributeBuilder->states[$state]();

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
    public function setAttribute($attribute, $value = null, $attributeType = null, $condition = null, $negateCondition = false, $state = null): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->attributeBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($value)) {
            // and have a state element
            if ($state) {
                // get the value of the state
                $stateValue = $this->attributeBuilder->states[$state]();

                // we need to get the value from the array
                $value = array_key_exists($stateValue, $value) ? $value[$stateValue] : null;
            }
        }

        // loop through each of the attributes that we need to remove
        foreach ($this->attributeBuilder->formatAttributes([$attribute => $value], $attributeType) as $attribute => $value) {
            $this->attributeBag->offsetSet($attribute, $value);
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
    public function removeAttribute($attribute, $attributeType = null, $condition = null, $negateCondition = false): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->attributeBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // make sure that the attributes are an array
        $attribute = (array) $attribute;

        // and then fill them with null
        $attribute = array_fill_keys($attribute, null);

        // loop through each of the attributes that we need to remove
        foreach ($this->attributeBuilder->formatAttributes($attribute, $attributeType) as $attribute => $value) {
            // and remove it
            $this->attributeBag->offsetUnset($attribute);
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
        return $this->attributeBag->get($attribute, $default);
    }

    /**
     * Return the current attribute bag
     *
     * @return ComponentAttributeBag
     */
    public function getAttributeBag()
    {
        return $this->attributeBag;
    }

    /**
     * Forward calls to the underlying attribute bag
     *
     * @param mixed $name
     * @param mixed $arguments
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        return $this->forwardCallTo($this->attributeBag, $name, $arguments);
    }
}
