<?php

namespace AppKit\UI;

use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\View\ComponentAttributeBag;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

class AttributeBuilder
{
    use ForwardsCalls;

    public function __construct(
        protected ComponentAttributeBag &$attributeBag,
        protected Collection $options
    ) {

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
     * @return AttributeBuilder
     */
    public function setAttribute($attribute, $value = null): AttributeBuilder
    {
        // set the attribute on the attribute bag
        $this->offsetSet($attribute, $value);

        // return a fluent API
        return $this;
    }

    /**
     * Get an attribute from the attribute bag
     *
     * @param mixed $attribute
     * @param mixed $default
     * @return AttributeBag
     */
    public function getAttribute($attribute, $default = null): AttributeBag
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
     * Return the underlying component attribute bag instance
     *
     * @return ComponentAttributeBag
     */
    public function getAttributeBag(): ComponentAttributeBag
    {
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
        return $this->forwardCallTo($this->attributeBag, $method, $parameters);
    }
}
