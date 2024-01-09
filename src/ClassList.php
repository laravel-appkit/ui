<?php

namespace AppKit\UI;

use Illuminate\Support\Arr;

class ClassList
{
    /**
     * Array to store the classes to be applied
     *
     * @var string[]
     */
    protected $classes = [];

    public function __construct(public AttributeBuilder $attributeBuilder, public ?string $element = null)
    {
        // pull out any default classes that the attribute builder had passed to it's constructor
        $defaultClasses = $this->attributeBuilder->getAttribute('class', element: $element);

        // if we have any
        if ($defaultClasses) {
            // split, and tidy them
            $this->classes = $this->getClassesFromString($defaultClasses);
        }
    }

    /**
     * Add a class (or classes) to the class list
     *
     * @param string|string[] ...$classes
     * @return void
     */
    public function add(...$classes)
    {
        // loop through all of the classes (in various methods) that should be added
        foreach ($this->prepareClasses($classes) as $class) {
            // check we don't already have it
            if (!$this->has($class)) {
                // merge it in to the end
                $this->classes[] = $class;
            }
        }

        // update the underlying attribute builder
        $this->updateAttributeBuilder();
    }

    /**
     * Remove a class from the class list
     *
     * @param string|string[] ...$classes
     * @return void
     */
    public function remove(...$classes)
    {
        // loop through all of the classes (in various methods) that should be added
        foreach ($this->prepareClasses($classes) as $class) {
            // check we don't already have it
            if ($this->has($class)) {
                // merge it in to the end
                $this->classes = array_diff($this->classes, [$class]);
            }
        }

        // update the underlying attribute builder
        $this->updateAttributeBuilder();
    }

    /**
     * Check if a particular class is in the class list
     *
     * @param string $class
     * @return bool
     */
    public function has($class): bool
    {
        return in_array($class, $this->classes);
    }

    /**
     * Generate the class string for the class list
     *
     * @return string
     */
    public function getClassString(): string
    {
        return Arr::toCssClasses($this->classes);
    }

    /**
     * Parse the classes into a flat array that only contains one class per item
     *
     * @param string|string[] $classes
     * @return array
     */
    public function prepareClasses($classes): array
    {
        // ensure that the classes are an array
        $classes = Arr::wrap($classes);

        return collect($classes)
            // flatten any nested arrays
            ->flatten()
            // go through each item and pull out any multi-class string
            ->map(fn ($class) => $this->getClassesFromString($class))
            // flatten it again as getClassesFromString will return an array
            ->flatten()
            // turn the collection back into an array
            ->toArray();
    }

    /**
     * Pull out individual class names from a string of classes
     *
     * @param string $classString
     * @return array
     */
    public function getClassesFromString($classString): array
    {
        // split up the string
        $classes = explode(' ', $classString);

        return collect($classes)
            // remove anything that is empty
            ->filter()
            // trim the items to ensure there is no whitespace
            ->map(fn ($class) => trim($class))
            // get only the unique ones
            ->unique()
            // and then covert back to an array
            ->toArray();
    }

    /**
     * Update the underlying attribute builder
     *
     * @return void
     */
    private function updateAttributeBuilder()
    {
        // get the class string
        $classList = $this->getClassString();

        // set the attribute on the attribute builder
        $this->attributeBuilder->setAttribute('class', $classList, element: $this->element);
    }
}
