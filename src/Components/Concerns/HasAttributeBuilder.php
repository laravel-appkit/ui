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
    public static function registerAttributeBuilderParser(Closure $closure, $weight = 10)
    {
        // if this is the first time that we are seeing the weight
        if (!array_key_exists($weight, static::$attributeBuilderParsers)) {
            // set up an array to store all of the closures of this weight
            static::$attributeBuilderParsers[$weight] = [];
        }

        // store the closure in the parses array
        static::$attributeBuilderParsers[$weight][] = $closure;
    }

    /**
     * @see registerAttributeBuilderParser
     */
    public static function customize(Closure $closure, $weight = 10)
    {
        // this is just an alias to registerAttributeBuilderParser
        static::registerAttributeBuilderParser(...func_get_args());
    }

    /**
     * @see registerAttributeBuilderParser
     */
    public static function customise(Closure $closure, $weight = 10)
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

        $this->attributeBuilderState[$state] = fn () => $this->{$property};
    }

    /**
     * Register a new element for the attribute builder
     *
     * @param string $element
     * @return ElementAttributeBagWrapper
     */
    protected function registerAttributeBuilderElement(string $element): ElementAttributeBagWrapper
    {
        // add the name to the array of elements
        $this->attributeBuilderElements[] = $element;

        // return a wrapper, as we will need to generate the actual content attributes later
        return new ElementAttributeBagWrapper($element);
    }

    /**
     * Run the attribute builder, and return the data that gets passed to the renderer
     *
     * @param array $data
     * @return array
     */
    protected function runAttributeBuilder(array $data): array
    {
        // get the instance of the attribute builder
        $this->attributeBuilder = new AttributeBuilder($data['attributes'], $this->attributeBuilderElements);

        foreach ($this->attributeBuilderState as $state => $closure) {
            $this->attributeBuilder->registerState($state, $closure);
        }

        // sort the parsers by their weight
        ksort(static::$attributeBuilderParsers);

        // loop through each of the weights
        foreach (static::$attributeBuilderParsers as $parsers) {
            // and then through each of the parser of that weight
            foreach ($parsers as $parser) {
                // run the parser
                $parser($this->attributeBuilder, $this);
            }
        }

        // pull out the "new" attributes
        $data['attributes'] = $this->attributeBuilder->getAttributeBag();

        // loop through each piece of data that we have
        foreach ($data as $dataName => $dataElement) {
            // check if it it's an instance of an element attribute bag
            if ($dataElement instanceof ElementAttributeBagWrapper) {
                // if it is, pull out the attributes and set everything we need to
                $this->{$dataName} = $data[$dataName] = $dataElement->run($this->attributeBuilder);
            }
        }

        // return the updated data
        return $data;
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
