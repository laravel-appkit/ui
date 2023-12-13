<?php

namespace AppKit\UI;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;

class AttributeBuilder
{
    public function __construct(
        protected ComponentAttributeBag &$attributeBag,
        protected Collection $options
    )
    {

    }

    public function addClass(...$classes)
    {
        $classes = Arr::flatten($classes);

        $this->merge(['class' => implode(' ', $classes)]);

        return $this;
    }

    public function addOptionClass($option, $classes) {
        $value = $this->options[$option];

        $classes = value($classes);

        if (array_key_exists($value, $classes)) {
            return $this->addClass($classes[$value]);
        }

        return $this;
    }

    public function setAttribute($attribute, $value = null)
    {
        $this->attributeBag->offsetSet($attribute, $value);

        return $this;
    }

    public function setData($key, $value = null)
    {
        $this->attributeBag->offsetSet('data-' . $key, $value);

        return $this;
    }

    public function merge($attributes) {
        $this->attributeBag = $this->attributeBag->merge($attributes);
    }

    public function getAttributeBag()
    {
        return $this->attributeBag;
    }
}
