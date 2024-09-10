<?php

namespace AppKit\UI\Components\Traits;

use Exception;
use Illuminate\View\Component;

trait InteractsWithComponentStack {
    /**
     * Find the closest ancestor that matches a particular class
     *
     * @param string|array $components
     * @param boolean $throw
     * @return Component|null
     */
    protected function closest(string|array $components, bool $throw = false): Component | null {
        // coerce the components into an array to make them consistent
        $components = (array) $components;

        // get the parent of this component
        $ancestor = $this->parentComponent;

        // set up a flag to keep track if we have found a suitable candidate
        $found = false;

        // iterate up the tree whilst we still have a parent, and haven't found what we are looking for
        while (!is_null($ancestor) && !$found) {
            if (in_array(get_class($ancestor), $components)) {
                $found = true;
            } else {
                $ancestor = $ancestor->parentComponent;
            }
        }

        // if we get to the top of the tree, and haven't found what we are looking for, maybe throw an exception
        if (!$found && $throw) {
            throw new Exception(self::class . ' components expects to be a descendant of a ' . implode(' or ', $components) . ' component');
        }

        // return the suitable candidate
        return $ancestor;
    }
}
