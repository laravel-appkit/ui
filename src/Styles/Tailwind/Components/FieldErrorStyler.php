<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Styles\Tailwind\Mixins\ComponentWidth;
use AppKit\UI\Styles\Tailwind\Mixins\InputFieldMixin;

class FieldErrorStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $componentBuilder, BaseComponent $instance): void
    {
        $componentBuilder->addClass(['text-red-600', 'dark:text-red-400']);
        // $componentBuilder->setAttribute('x-text', 'form.errors.' . $instance->name);
    }
}
