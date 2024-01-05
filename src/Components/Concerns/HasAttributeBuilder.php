<?php

namespace AppKit\UI\Components\Concerns;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\ElementAttributeBagWrapper;
use Closure;

trait HasAttributeBuilder
{
    /**
     * The parsers that the attribute builder should be run through
     * @var array<int,array<int,Closure>>
     */
    protected static $attributeBuilderParsers = [];

    /**
     * The elements that have been specified for the attribute builder
     * @var array<string>
     */
    protected $attributeBuilderElements = [];

    /**
     * The instance of the Attribute Builder
     * @var AttributeBuilder
     */
    protected AttributeBuilder $attributeBuilder;

    protected $attributeBuilderState = [];

    /**
     * Add a new attribute builder parser at a given weight
     *
     * @param Closure $closure
     * @param int $weight
     * @return void
     */
    public static function registerAttributeBuilderParser(callable $closure, $weight = 10)
    {
        // if this is the first time that we are seeing the weight
        if (!array_key_exists(static::class, static::$attributeBuilderParsers)) {
            // set up an array to store all of the closures of this weight
            static::$attributeBuilderParsers[static::class] = [];
        }

        // if this is the first time that we are seeing the weight
        if (!array_key_exists($weight, static::$attributeBuilderParsers[static::class])) {
            // set up an array to store all of the closures of this weight
            static::$attributeBuilderParsers[static::class][$weight] = [];
        }

        // store the closure in the parses array
        static::$attributeBuilderParsers[static::class][$weight][spl_object_hash($closure)] = $closure;
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
     * Reset all of the attribute builder parsers
     *
     * @return void
     */
    public static function resetAllAttributeBuilderParsers()
    {
        // empty out the array
        static::$attributeBuilderParsers = [];
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

    public function exposePropertyAsState($property, $state = null)
    {
        if (!$state) {
            $state = $property;
        }

        if (!array_key_exists(static::class, $this->attributeBuilderState)) {
            $this->attributeBuilderState[static::class] = [];
        }

        $this->attributeBuilderState[static::class][$state] = fn () => $this->{$property};
    }

    /**
     * Register a new element for the attribute builder
     *
     * @param string $element
     * @return ElementAttributeBagWrapper
     */
    protected function registerAttributeBuilderElement(string $element): ElementAttributeBagWrapper
    {
        if (!array_key_exists(static::class, $this->attributeBuilderElements)) {
            $this->attributeBuilderElements[static::class] = [];
        }

        // add the name to the array of elements
        $this->attributeBuilderElements[static::class][] = $element;

        // return a wrapper, as we will need to generate the actual content attributes later
        return new ElementAttributeBagWrapper($element);
    }

    /**
     * Get the underlying attribute builder instance
     *
     * @return AttributeBuilder
     */
    public function getAttributeBuilder(): AttributeBuilder
    {
        return $this->attributeBuilder;
    }
}
