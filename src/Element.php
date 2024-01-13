<?php

namespace AppKit\UI;

use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

    public function __construct(protected ComponentBuilder $componentBuilder, protected ComponentAttributeBag $attributeBag)
    {
        // create the class list for this element
        $this->classList = new ClassList($componentBuilder, $this);
    }

    /**
     * Add classes to the attribute bag
     *
     * @param mixed $classes
     * @return ComponentBuilder
     * @throws InvalidArgumentException
     */
    public function addClass($classes, $condition = null, $negateCondition = false, $state = null): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->componentBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($classes) && $state) {
            // get the value of the state
            $stateValue = $this->componentBuilder->states[$state]();

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
     * @return ComponentBuilder
     */
    public function removeClass($classes, $condition = null, $negateCondition = false, $state = null): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->componentBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($classes) && $state) {
            // get the value of the state
            $stateValue = $this->componentBuilder->states[$state]();

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
     * @return ComponentBuilder
     * @throws RuntimeException
     */
    public function setAttribute($attribute, $value = null, $attributeType = null, $condition = null, $negateCondition = false, $state = null): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->componentBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // if we have passed in and array
        if (is_array($value)) {
            // and have a state element
            if ($state) {
                // get the value of the state
                $stateValue = $this->componentBuilder->states[$state]();

                // we need to get the value from the array
                $value = array_key_exists($stateValue, $value) ? $value[$stateValue] : null;
            }
        }

        // loop through each of the attributes that we need to remove
        foreach ($this->componentBuilder->formatAttributes([$attribute => $value], $attributeType) as $attribute => $value) {
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
     * @return ComponentBuilder
     * @throws RuntimeException
     */
    public function removeAttribute($attribute, $attributeType = null, $condition = null, $negateCondition = false): Element
    {
        // if we have a conditional, we need to check if it passes
        if ($condition != null && !$this->componentBuilder->conditionalPasses($condition, $negateCondition)) {
            return $this;
        }

        // make sure that the attributes are an array
        $attribute = Arr::wrap($attribute);

        // and then fill them with null
        $attribute = array_fill_keys($attribute, null);

        // loop through each of the attributes that we need to remove
        foreach ($this->componentBuilder->formatAttributes($attribute, $attributeType) as $attribute => $value) {
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
     * Set an attribute value via magic parameter
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        // turn the name of the attribute into kebab case
        $name = Str::of($name)->kebab()->__toString();

        // if the value is null
        if ($value === null) {
            // we unset the attribute
            $this->removeAttribute($name);
        } else {
            // set the attribute
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Unset an attribute value via a magic parameter
     *
     * @param string $name
     * @return void
     */
    public function __unset(string $name): void
    {
        // turn the name of the attribute into kebab case
        $name = Str::of($name)->kebab()->__toString();

        // remove the attribute
        $this->removeAttribute($name);
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
