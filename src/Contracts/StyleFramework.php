<?php

namespace AppKit\UI\Contracts;

interface StyleFramework
{
    /**
     * (Optionally) return the name of the styler class for a particular component
     *
     * @param string $component
     * @return null|string
     */
    public function locateStylerForComponent(string $component): ?string;
}
