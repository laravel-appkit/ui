<?php

namespace AppKit\UI\Components;

class FieldRequirement extends BaseComponent
{
    /**
     * Are optional fields highlighted
     *
     * @var bool
     */
    public bool $highlightOptionalFields;

    /**
     * Create an instance of the component
     *
     * @param bool $required
     * @param string $requiredText
     * @param string $optionalText
     */
    public function __construct(
        public bool $required = false,
        public string $requiredText = '*',
        public string $optionalText = ' (Optional)',
    ) {
        $this->highlightOptionalFields = config('appkit-ui::highlight_optional_fields', false);

        // constructor promotion handles the rest
    }
}
