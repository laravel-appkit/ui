<?php

namespace AppKit\UI\Styles\Tailwind;

use AppKit\UI\Contracts\StyleFramework;

class Tailwind implements StyleFramework
{
    /**
     * (Optionally) return the name of the styler class for a particular component
     *
     * @param string $component
     * @return null|string
     */
    public function locateStylerForComponent(string $component): ?string
    {
        // generate the namespace to the component
        $class = __NAMESPACE__ . '\Components\\' . class_basename($component) . 'Styler';

        // check that the class exists, and return the name of it
        return class_exists($class) ? $class : null;
    }

    public function getColorClasses(string $color, int $scale = 600, string $property = 'bg', $includeText = false, $includeHover = false, string $prefix = '')
    {
        $classes = [];

        // add in the default class
        $classes[] = $prefix . implode('-', [$property, $color, $scale]);

        if ($includeText) {
            $classes[] = $prefix . $this->getTextOnColorClass($color, $scale);
        }

        if ($includeHover) {
            $hoverClasses = $this->getColorClasses($color, $this->getHoverColorScale($color, $scale), $property, $includeText, false, 'hover:');

            $classes = array_merge($classes, $hoverClasses);
        }

        // if ($prefix != 'dark:') {
        //     $darkModeClasses = $hoverClasses = $this->getColorClasses($color, $this->getDarkModeColorScale($color, $scale), $property, $includeText, $includeHover, 'dark:');

        //     $classes = array_merge($classes, $darkModeClasses);
        // }

        return array_reverse($classes);
    }

    public function getTextOnColorClass(string $color, int $scale)
    {
        return $scale < 500 ? 'text-black' : 'text-white';
    }

    public function getHoverColorScale(string $color, int $scale)
    {
        return $scale > 100 ? ($scale - 100) : ($scale + 100);
    }

    public function getDarkModeColorScale(string $color, int $scale)
    {
        return 900 - $scale;
    }
}
