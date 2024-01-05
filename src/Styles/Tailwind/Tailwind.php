<?php

namespace AppKit\UI\Styles\Tailwind;

use AppKit\UI\Contracts\StyleFramework;
use RuntimeException;

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

    /**
     * Get the tailwind classes that need to be applied to make an element a particular color
     *
     * @param string $color
     * @param int $scale
     * @param string $property
     * @param array $include
     * @return string[]
     * @throws RuntimeException
     */
    public function getColorClasses(string $color, int $scale = 600, string $property = 'bg', $include = [])
    {
        // the array of classes that we need to add
        $classes = [];

        // valid things that can be included
        $validIncludes = [
            'hover',
            'outline',
            'text',
        ];

        // validate that we are only passing through valid includes
        foreach ($include as $possibleInclude) {
            if (!in_array($possibleInclude, $validIncludes)) {
                throw new RuntimeException('Invalid color include ' . $possibleInclude);
            }
        }

        // get the dark mode color scale
        $darkModeColorScale = $this->getDarkModeColorScale($color, $scale);

        // add in the default class
        $classes[] = $this->generateColorClass($color, $scale, $property);
        $classes[] = $this->generateColorClass($color, $darkModeColorScale, $property, 'dark');

        // check if we we need to add in classes for the outline too
        if (in_array('outline', $include)) {
            $classes[] = $this->generateColorClass($color, $scale, 'outline', 'focus-visible');
            $classes[] = $this->generateColorClass($color, $darkModeColorScale, 'outline', 'dark:focus-visible');
        }

        // check if we are including text
        if (in_array('text', $include)) {
            // get the scale for the text on color
            $textOnColor = $this->getTextOnColorScale($color, $scale);
            $textOnDarkColor = $this->getTextOnColorScale($color, $darkModeColorScale);

            // add the color to the classes
            $classes[] = $this->generateColorClass($textOnColor, null, 'text');
            $classes[] = $this->generateColorClass($textOnDarkColor, null, 'text', 'dark');
        }

        // check if we should be including a hover
        if (in_array('hover', $include)) {
            // get the scale color of the hover state
            $hoverBackgroundScale = $this->getHoverColorScale($color, $scale);
            $hoverBackgroundScaleDarkMode = $this->getHoverColorScale($color, $darkModeColorScale);

            // add the hover color to the classes
            $classes[] = $this->generateColorClass($color, $hoverBackgroundScale, $property, 'hover');
            $classes[] = $this->generateColorClass($color, $hoverBackgroundScaleDarkMode, $property, 'dark:hover');

            // check if we are including a hover color
            if (in_array('text', $include)) {
                // get the scale for the text on color
                $textOnColor = $this->getTextOnColorScale($color, $hoverBackgroundScale);
                $textOnColorDarkMode = $this->getTextOnColorScale($color, $hoverBackgroundScaleDarkMode);

                // add the color to the classes
                $classes[] = $this->generateColorClass($textOnColor, null, 'text', 'hover');
                $classes[] = $this->generateColorClass($textOnColorDarkMode, null, 'text', 'dark:hover');
            }
        }

        return array_reverse($classes);
    }

    /**
     * Generate a css class for a color
     *
     * @param mixed $color
     * @param mixed $scale
     * @param mixed $property
     * @param string $prefix
     * @return string
     */
    private function generateColorClass($color, $scale, $property, $prefix = '')
    {
        // the parts of the class
        $parts = [$property, $color, $scale];

        // we may have specified a prefix
        if ($prefix) {
            // and need to add a colon to the end of it
            $prefix = $prefix . ':';
        }

        // make the class name
        return $prefix . implode('-', array_filter($parts));
    }

    /**
     * Get the color of the text that should be placed on a given background color/scale
     *
     * @param string $color
     * @param int $scale
     * @return string
     */
    public function getTextOnColorScale(string $color, int $scale)
    {
        return $scale < 500 ? 'black' : 'white';
    }

    /**
     * Get the hover colour scale for a given background color/scale
     *
     * @param string $color
     * @param int $scale
     * @return int
     */
    public function getHoverColorScale(string $color, int $scale)
    {
        return $scale > 100 ? ($scale - 100) : ($scale + 100);
    }

    /**
     * Get the corresponding dark mode scale for a given color/scale
     *
     * @param string $color
     * @param int $scale
     * @return int
     */
    public function getDarkModeColorScale(string $color, int $scale)
    {
        return 900 - $scale;
    }
}
