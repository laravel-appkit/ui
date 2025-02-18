<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Slotable;
use AppKit\UI\ElementAttributeBag;

class Alert extends BaseComponent
{
    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $titleAttributes;

    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $contentAttributes;

    /**
     * Attributes to be applied to the error message
     *
     * @var ElementAttributeBag
     */
    public ElementAttributeBag $iconAttributes;

    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.alert';

    public function __construct(
        #[Slotable]
        public ?string $title = null,
        #[Slotable]
        public ?string $icon = null,
        public ?string $type = 'success',
    ) {
        $this->titleAttributes = $this->registerAttributeBuilderElement('title');
        $this->contentAttributes = $this->registerAttributeBuilderElement('content');
        $this->iconAttributes = $this->registerAttributeBuilderElement('icon');

        $this->exposePropertyAsState('type');
    }
}
