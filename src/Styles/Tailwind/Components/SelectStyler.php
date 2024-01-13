<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Styles\Tailwind\Mixins\ComponentWidth;
use AppKit\UI\Styles\Tailwind\Mixins\InputFieldMixin;

class SelectStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $componentBuilder): void
    {
        // add the default field styling
        $componentBuilder->mixin(InputFieldMixin::class);

        // handle the component width
        $componentBuilder->mixin(ComponentWidth::class);

        // This crazy class is required to make sure the options text is readable
        $componentBuilder->addClass('dark:[&_*]:text-black');
    }
}
