<?php

namespace AppKit\UI\Components;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Components\Concerns\HasAttributeBuilder;
use AppKit\UI\ElementAttributeBagWrapper;
use Illuminate\View\Component as BladeComponent;

abstract class BaseComponent extends BladeComponent
{
    use HasAttributeBuilder;

    protected $viewName = null;

    /**
     * Set the extra attributes that the component should make available.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function withAttributes(array $attributes)
    {
        // ensure that we have an attribute bag assigned to the component
        $this->attributes = $this->attributes ?: $this->newAttributeBag();

        // create the new attribute bag that we will pass to the attribute builder
        $attributeBag = $this->newAttributeBag($attributes);

        // get the instance of the attribute builder
        $this->attributeBuilder = new AttributeBuilder($attributeBag, $this->attributeBuilderElements);

        // loop through the attribute builder states
        foreach ($this->attributeBuilderState as $state => $closure) {
            // and register them
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
        $this->attributes = $this->attributes->setAttributes($this->attributeBuilder->getAttributeBag()->getAttributes());

        // loop through each piece of data that we have
        foreach ($this->data() as $dataName => $dataElement) {
            // check if it it's an instance of an element attribute bag
            if ($dataElement instanceof ElementAttributeBagWrapper) {
                // if it is, pull out the attributes and set everything we need to
                $this->{$dataName} = $dataElement->run($this->attributeBuilder);
            }
        }

        return $this;
    }

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return $this->viewName;
    }
}
