<?php

namespace AppKit\UI\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\Concerns\HasComponentBuilder;
use AppKit\UI\ElementAttributeBagWrapper;
use AppKit\UI\Facades\UI;
use Illuminate\Console\View\Components\Component;
use Illuminate\View\Component as BladeComponent;
use Illuminate\View\Factory;

abstract class BaseComponent extends BladeComponent
{
    use HasComponentBuilder;

    protected $viewName = null;

    public $elements = [];

    public $parentComponent;

    public $childComponents = [];

    /**
     * Set the extra attributes that the component should make available.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function withAttributes(array $attributes)
    {
        UI::startComponent($this);

        // ensure that we have an attribute bag assigned to the component
        $this->attributes = $this->attributes ?: $this->newAttributeBag();

        // create the new attribute bag that we will pass to the component builder
        $attributeBag = $this->newAttributeBag($attributes);

        $elements = array_key_exists(static::class, $this->componentBuilderElements) ? $this->componentBuilderElements[static::class] : [];

        // get the instance of the component builder
        $this->componentBuilder = new ComponentBuilder($attributeBag, $elements);

        // loop through the component builder states
        if (array_key_exists(static::class, $this->componentBuilderState)) {
            foreach ($this->componentBuilderState[static::class] as $state => $closure) {
                // and register them
                $this->componentBuilder->registerState($state, $closure);
            }
        }

        // sort the parsers by their weight
        ksort(static::$componentBuilderParsers);

        if (array_key_exists(static::class, static::$componentBuilderParsers)) {
            // loop through each of the weights
            foreach (static::$componentBuilderParsers[static::class] as $parsers) {
                // and then through each of the parser of that weight
                foreach ($parsers as $parser) {
                    // run the parser
                    $parser($this->componentBuilder, $this);
                }
            }
        }

        // pull out the "new" attributes
        $this->attributes = $this->attributes->setAttributes($this->componentBuilder->getAttributeBag()->getAttributes());

        // loop through each piece of data that we have
        foreach ($this->data() as $dataName => $dataElement) {
            // check if it it's an instance of an element attribute bag
            if ($dataElement instanceof ElementAttributeBagWrapper) {
                // if it is, pull out the attributes and set everything we need to
                $this->{$dataName} = $dataElement->run($this->componentBuilder);

                $this->elements[$dataName] = $this->{$dataName};
            }
        }

        return $this;
    }

    public function addChildComponent(BladeComponent $component)
    {
        $this->childComponents[] = $component;
    }

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return function ($data) {
            UI::renderingComponent($this);

            $data['childComponents'] = $this->childComponents;

            return view($this->viewName, $data)->render();
        };
    }
}
