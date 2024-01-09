<?php

namespace AppKit\UI;

use Illuminate\Support\Arr;

class ClassList
{
    protected $classes = [];

    public function __construct(public AttributeBuilder $attributeBuilder, public ?string $element = null)
    {
        // pull out any default classes that the attribute builder had passed to it's constructor
        $defaultClasses = $this->attributeBuilder->getAttribute('class', element: $element);

        // if we have any
        if ($defaultClasses) {
            // split, and tidy them
            $this->classes = collect(explode(' ', $defaultClasses))
                ->filter()
                ->map(fn ($class) => trim($class))
                ->unique()
                ->toArray();
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
        foreach (Arr::flatten(Arr::wrap($classes)) as $class) {
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
        foreach (Arr::flatten(Arr::wrap($classes)) as $class) {
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
     * @return boolean
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
