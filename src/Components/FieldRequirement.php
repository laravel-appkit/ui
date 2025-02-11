<?php

namespace AppKit\UI\Components;

class FieldRequirement extends BaseComponent
{
    /**
     * The name of the view that this component renders
     *
     * @var string
     */
    protected string $viewName = 'components.field-requirement';

    public bool $highlightOptionalFields;

    public function __construct(
        public bool $required = false,
        public string $requiredText = '*',
        public string $optionalText = ' (Optional)',
    ) {
        $this->highlightOptionalFields = config('appkit-ui::highlight_optional_fields', false);
    }
}
