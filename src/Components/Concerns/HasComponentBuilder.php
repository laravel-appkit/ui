<?php

namespace AppKit\UI\Components\Concerns;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\ElementAttributeBagWrapper;
use Closure;

trait HasComponentBuilder
{
    /**
     * The parsers that the component builder should be run through
     * @var array<int,array<int,Closure>>
     */
    protected static $componentBuilderParsers = [];

    /**
     * The elements that have been specified for the component builder
     * @var array<string>
     */
    protected $componentBuilderElements = [];

    /**
     * The instance of the Attribute Builder
     * @var ComponentBuilder
     */
    protected ComponentBuilder $componentBuilder;

    protected $componentBuilderState = [];

    /**
     * Add a new component builder parser at a given weight
     *
     * @param Closure $closure
     * @param int $weight
     * @return void
     */
    public static function registerAttributeBuilderParser(callable $closure, $weight = 10)
    {
        // if this is the first time that we are seeing the weight
        if (!array_key_exists(static::class, static::$componentBuilderParsers)) {
            // set up an array to store all of the closures of this weight
            static::$componentBuilderParsers[static::class] = [];
        }

        // if this is the first time that we are seeing the weight
        if (!array_key_exists($weight, static::$componentBuilderParsers[static::class])) {
            // set up an array to store all of the closures of this weight
            static::$componentBuilderParsers[static::class][$weight] = [];
        }

        // store the closure in the parses array
        static::$componentBuilderParsers[static::class][$weight][spl_object_hash($closure)] = $closure;
    }

    /**
     * @see registerAttributeBuilderParser
     */
    public static function customize(callable $closure, $weight = 10)
    {
        // this is just an alias to registerAttributeBuilderParser
        static::registerAttributeBuilderParser(...func_get_args());
    }

    /**
     * @see registerAttributeBuilderParser
     */
    public static function customise(callable $closure, $weight = 10)
    {
        // this is just an alias to registerAttributeBuilderParser
        static::registerAttributeBuilderParser(...func_get_args());
    }

    /**
     * Reset all of the component builder parsers
     *
     * @return void
     */
    public static function resetAllAttributeBuilderParsers()
    {
        // empty out the array
        static::$componentBuilderParsers = [];
    }

    /**
     * @see resetAllAttributeBuilderParsers
     */
    public static function resetAllCustomisations()
    {
        // this is just an alias to resetAllAttributeBuilderParsers
        static::resetAllAttributeBuilderParsers();
    }

    /**
     * @see resetAllAttributeBuilderParsers
     */
    public static function resetAllCustomizations()
    {
        // this is just an alias to resetAllAttributeBuilderParsers
        static::resetAllAttributeBuilderParsers();
    }

    public function defineState(string $state, closure $closure)
    {
        if (!array_key_exists(static::class, $this->componentBuilderState)) {
            $this->componentBuilderState[static::class] = [];
        }

        $this->componentBuilderState[static::class][$state] = $closure;
    }

    public function exposePropertyAsState($property, $state = null)
    {
        if (!$state) {
            $state = $property;
        }

        if (!array_key_exists(static::class, $this->componentBuilderState)) {
            $this->componentBuilderState[static::class] = [];
        }

        $this->componentBuilderState[static::class][$state] = fn () => $this->{$property};
    }

    /**
     * Register a new element for the component builder
     *
     * @param string $element
     * @return ElementAttributeBagWrapper
     */
    protected function registerAttributeBuilderElement(string $element): ElementAttributeBagWrapper
    {
        if (!array_key_exists(static::class, $this->componentBuilderElements)) {
            $this->componentBuilderElements[static::class] = [];
        }

        // add the name to the array of elements
        $this->componentBuilderElements[static::class][] = $element;

        // return a wrapper, as we will need to generate the actual content attributes later
        return new ElementAttributeBagWrapper($element);
    }

    /**
     * Get the underlying component builder instance
     *
     * @return ComponentBuilder
     */
    public function getAttributeBuilder(): ComponentBuilder
    {
        return $this->componentBuilder;
    }
}
