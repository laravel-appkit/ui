<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\AttributeBuilder;
use AppKit\UI\Styles\Tailwind\Mixins\ComponentWidth;
use AppKit\UI\Styles\Tailwind\Mixins\InputFieldMixin;

class SelectStyler extends BaseStyler
{
    public function __invoke(AttributeBuilder $attributeBuilder): void
    {
        // add the default field styling
        $attributeBuilder->mixin(InputFieldMixin::class);

        // handle the component width
        $attributeBuilder->mixin(ComponentWidth::class);

        // This crazy class is required to make sure the options text is readable
        $attributeBuilder->addClass('dark:[&_*]:text-black');
    }
}
