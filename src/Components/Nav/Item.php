<?php

namespace AppKit\UI\Components\Nav;

use AppKit\UI\Attributes\State;
use AppKit\UI\Components\BaseComponent;
use Illuminate\Support\Facades\Request;

class Item extends BaseComponent
{
    /**
     * Create an instance of the component
     */
    public function __construct(
        #[State]
        public bool $current = false,
        public ?string $href = null,
        public ?string $route = null,
    ) {
        if (!$this->href && $this->route) {
            $this->href = route($this->route);
        }

        if ($this->route && !$this->current) {
            $this->current = (Request::url() == route($this->route));
        }
    }
}
