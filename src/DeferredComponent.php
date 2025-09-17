<?php

namespace AppKit\UI;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ComponentSlot;
use Stringable;

class DeferredComponent implements Htmlable, Stringable
{
    /**
     * A collection of all of the slots that are going to be passed to the component
     *
     * @var Collection
     */
    protected Collection $slots;

    /**
     * A fluent object that is going to be used to store all of the configuration for the component
     *
     * @var Fluent
     */
    protected Fluent $options;

    /**
     * Create an deferred component
     *
     * @param string $target The component that will be rendered
     * @param array $options All of the options that will be passed to the component
     */
    public function __construct(public string $target, $options = [])
    {
        // initialise the slots
        $this->slots = new Collection();

        // store the options in the fluent object
        $this->options = new Fluent($options);
    }

    /**
     * Create a fluent API that will allow options to be set on the object
     *
     * @param string $name
     * @param string $arguments
     * @return self
     */
    public function __call($name, $arguments): self
    {
        $this->options->$name(...$arguments);

        return $this;
    }

    /**
     * Pass contents to one of the slots in the underlying component
     *
     * @param string|array|Collection $content
     * @param string $slot
     * @param array $attributes
     * @return self
     */
    public function slot(string|array|Collection $content, string $slot = '__default', array $attributes = []): self
    {
        dump(func_get_args());

        // if we are passing an array, convert it to a collection to make our lives easier
        if (is_array($content)) {
            $content = new Collection($content);
        }

        // if we now have a collection, we need to render all of the items in the collection
        if ($content instanceof Collection) {
            $content = $content
                ->map(function ($element) {
                    // if we are another deferred component
                    if ($element instanceof DeferredComponent) {
                        // then we render it now
                        return $element->toHtml();
                    }

                    // otherwise, we will just pass it through
                    return $element;
                })
                ->join(PHP_EOL);
        }

        // create a slot instance, this makes everything easier when we generate the component
        $newSlot = new ComponentSlot($content, $attributes);

        // store the slot in our collection of slots
        $this->slots[$slot] = $newSlot;

        return $this;
    }

    /**
     * Render the component to html
     *
     * @return string
     */
    public function toHtml(): string
    {
        // make a component attribute bag with all of the configuration that we have
        $attributes = new ComponentAttributeBag($this->options->toArray());

        // get all of the data for the component
        $data = [
            'componentName' => 'appkit::' . class_basename($this->target),
            'attributes' => $attributes,
            'slotContent' => $this->slots,
        ];

        // and add in each of the slots as an item
        foreach ($this->slots as $name => $content) {
            $data[$name] = $content;
        }

        // load the deferred component view, and render it
        return view('appkit-ui::deferred-component', $data)->render();
    }

    /**
     * Convert the class to a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toHtml();
    }
}
