<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Inheritable;
use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\Concerns\HasComponentBuilder;
use AppKit\UI\ElementAttributeBag;
use AppKit\UI\Facades\UI;
use AppKit\UI\Support\Attributes;
use Attribute;
use Illuminate\Support\Collection;
use Illuminate\View\Component as BladeComponent;
use Illuminate\View\ComponentAttributeBag;
use ReflectionClass;
use ReflectionProperty;
use YieldStudio\TailwindMerge\TailwindMerge;
use YieldStudio\TailwindMerge\TailwindMergeConfig;

abstract class BaseComponent extends BladeComponent
{
    use HasComponentBuilder;

    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = '';

    public array $elements = [];

    public ?BaseComponent $parentComponent = null;

    public ?Collection $childComponents = null;

    public ?int $siblingIndex = null;

    /**
     * Set the extra attributes that the component should make available.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function withAttributes(array $attributes)
    {
        UI::startComponent($this);

        $this->childComponents = new Collection();

        // ensure that we have an attribute bag assigned to the component
        $this->attributes = $this->attributes ?: $this->newAttributeBag();

        // handle situations where attributes have been passed in to the component as a attribute bag
        if (array_key_exists('attributes', $attributes) && $attributes['attributes'] instanceof ComponentAttributeBag) {
            $promotedAttributes = $attributes['attributes']->getAttributes();

            unset($attributes['attributes']);
            $attributes = array_merge($attributes, $promotedAttributes);
        }

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

        $newAttributes = $this->componentBuilder->getAttributeBag()->getAttributes();

        $twMerge = new TailwindMerge(TailwindMergeConfig::default()); // Config is optional

        if (array_key_exists('class', $newAttributes)) {
            $newAttributes['class'] = $twMerge->merge($newAttributes['class']);
        }

        // pull out the "new" attributes
        $this->attributes = $this->attributes->setAttributes($newAttributes);

        // loop through each piece of data that we have
        foreach ($this->data() as $dataName => $dataElement) {
            // check if it it's an instance of an element attribute bag
            if ($dataElement instanceof ElementAttributeBag) {
                // if it is, pull out the attributes and set everything we need to
                $this->{$dataName} = $dataElement->setComponentBuilder($this->componentBuilder);

                $this->elements[$dataName] = $this->{$dataName};
            }
        }

        return $this;
    }

    public function addChildComponent(BladeComponent $component)
    {
        $this->childComponents[] = $component;
    }

    public function parentSet()
    {

    }

    public function build()
    {

    }

    /**
     * Check if we have any constructor parameters that have an inheritable attribute on it
     *
     * @return void
     */
    public function buildInheritableParameters()
    {
        // get the list of the inheritable parameters
        $inheritableParameters = Attributes::find(Inheritable::class)
            ->onConstructorParameters()
            ->ofClass(static::class)
            ->get();

        // check if we have any inheritable parameters
        if ($inheritableParameters) {
            // then loop through them
            foreach ($inheritableParameters as $parameter => $inheritableAttribute) {
                // we only care about them if it's null
                if (is_null($this->{$parameter})) {
                    // find the closes applicable component
                    $inheritsFrom = $this->closest($inheritableAttribute->fromComponents, true);

                    // use the parent as the source of the attribute
                    $this->{$parameter} = $inheritsFrom->{$parameter};
                }
            }
        }
    }

    /**
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return function ($data) {
            // signal that we are about to render this component
            UI::renderingComponent($this);

            // build the inheritable parameters that have the Inheritable attribute on them
            $this->buildInheritableParameters();

            // build anything custom for the component
            $this->build();

            // get a reflection for this component
            $reflection = new ReflectionClass($this);

            // loop through the public properties
            $properties = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC))
                ->reject(function (ReflectionProperty $property) {
                    // we don't care if they are static
                    return $property->isStatic();
                })
                ->reject(function (ReflectionProperty $property) {
                    // and anything we have signaled that should be ignored
                    return $this->shouldIgnore($property->getName());
                })
                ->reject(function (ReflectionProperty $property) {
                    // get the name of the property
                    $name = $property->getName();

                    // because we are going to have changed both of these (probably), then we don't need to deal with them here
                    return $name == 'attributes' || $name == 'elements';
                })
                ->reject(function (ReflectionProperty $property) use ($data) {
                    // We also don't want to deal with anything that is an ElementAttributeBag
                    return is_a($data[$property->getName()], ElementAttributeBag::class);
                })
                ->map(function (ReflectionProperty $property) {
                    // now, we pull out the names of what's left
                    return $property->getName();
                })->all();

            // loop through all of the public properties that we aren't dealing with on their own
            foreach ($properties as $property) {
                // check if the data that will be passed to the renderer has been updated via a build method
                if ($data[$property] != $this->{$property}) {
                    // if it has, we update it to be the new value
                    $data[$property] = $this->{$property};
                }
            }

            // if we have inheritable attributes on the component (attributes passed in from another attribute bag)
            if (isset($data['inheritedAttributes'])) {
                // we merge them in right at the end
                $data['attributes'] = $data['attributes']->merge($this->inheritedAttributes);
            }

            // now we render the view
            return view('appkit-ui::' . $this->viewName, $data)->render();
        };
    }
}
