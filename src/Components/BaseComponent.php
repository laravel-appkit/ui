<?php

namespace AppKit\UI\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\Concerns\HasComponentBuilder;
use AppKit\UI\ElementAttributeBag;
use AppKit\UI\Facades\UI;
use Illuminate\Support\Collection;
use Illuminate\View\Component as BladeComponent;
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
     * Render the component
     *
     * @return Closure
     */
    public function render()
    {
        return function ($data) {
            UI::renderingComponent($this);

            $this->build();

            $class = get_class($this);

            // dump($class);

            $reflection = new ReflectionClass($this);

            $properties = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC))
                ->reject(function (ReflectionProperty $property) {
                    return $property->isStatic();
                })
                ->reject(function (ReflectionProperty $property) {
                    return $this->shouldIgnore($property->getName());
                })
                ->reject(function (ReflectionProperty $property) {
                    $name = $property->getName();

                    return $name == 'attributes' || $name == 'elements';
                })
                ->reject(function (ReflectionProperty $property) use ($data) {
                    return is_a($data[$property->getName()], ElementAttributeBag::class);
                })
                ->map(function (ReflectionProperty $property) {
                    return $property->getName();
                })->all();

            foreach ($properties as $property) {
                if ($data[$property] != $this->{$property}) {

                    $data[$property] = $this->{$property};
                }
            }

            return view('appkit-ui::' . $this->viewName, $data)->render();
        };
    }
}
