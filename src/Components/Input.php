<?php

namespace AppKit\UI\Components;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Attributes\ExposedAsState;
use AppKit\UI\ElementAttributeBag;
use Illuminate\Support\Str;

class Input extends BaseComponent
{
    /**
     * The attributes that get applied to the wrapper
     *
     * @var ElementAttributeBag|null
     */
    #[Element('wrapper')]
    public ?ElementAttributeBag $wrapperElement = null;

    public function __construct(
        public string $name,
        public string $label = '',
        public string $postfix = '',
        public string $prefix = '',
        public string $type = 'text',
        #[ExposedAsState]
        public string $width = 'md',
        public string $id = '',
        #[ExposedAsState]
        public bool $hasError = false,
        public bool $multiple = false,
    ) {
        // if we don't have an id passed in, we should use the name as the ID
        if (!$this->id) {
            $this->id = $this->name;
        }

        // ensure that multiples get the necessary bracket notation
        if ($this->multiple && !Str::of($this->name)->endsWith('[]')) {
            $this->name .= '[]';
        }
    }

    #[ExposedAsState]
    public function hasPrefix()
    {
        return !empty($this->prefix);
    }

    #[ExposedAsState]
    public function hasPostfix()
    {
        return !empty($this->postfix);
    }

    #[ExposedAsState]
    public function hasAffix()
    {
        return !empty($this->prefix) || !empty($this->postfix);
    }

    #[ExposedAsState]
    public function isCheckbox()
    {
        return $this->type === 'checkbox';
    }

    #[ExposedAsState]
    public function isRadioButton()
    {
        return $this->type === 'radio';
    }

    #[ExposedAsState]
    public function isCheckable()
    {
        return $this->type === 'checkbox' || $this->type === 'radio';
    }

    // TODO: Move this to the inheritable attribute
    public function parentSet()
    {
        if ($this->parentComponent instanceof (FieldGroup::class) && $this->parentComponent->error) {
            $this->hasError = true;
        }
    }
}
