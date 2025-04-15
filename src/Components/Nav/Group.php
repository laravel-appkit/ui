<?php

namespace AppKit\UI\Components\Nav;

use AppKit\UI\Attributes\Element;
use AppKit\UI\Components\BaseComponent;
use AppKit\UI\ElementAttributeBag;

class Group extends BaseComponent
{
    /**
     * The attributes that get applied to the title of the group
     *
     * @var ElementAttributeBag|null
     */
    #[Element('title')]
    public ?ElementAttributeBag $titleElement = null;

    /**
     * Create an instance of the component
     */
    public function __construct(
        public string $title,
    )
    {
        // constructor promotion handles the rest
    }
}
