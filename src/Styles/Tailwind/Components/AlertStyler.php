<?php

namespace AppKit\UI\Styles\Tailwind\Components;

use AppKit\UI\ComponentBuilder;
use AppKit\UI\Components\BaseComponent;

class AlertStyler extends BaseStyler
{
    public function __invoke(ComponentBuilder $component, BaseComponent $instance): void
    {
        $component
            // handle the main styling of the component
            ->addClass('rounded-md p-4 mb-4')
            // and the background color of the alert
            ->addClassForType([
                'error' => ['bg-red-50', 'dark:bg-red-800'],
                'info' => ['bg-sky-50', 'dark:bg-sky-800'],
                'success' => ['bg-green-50', 'dark:bg-green-800'],
                'warning' => ['bg-orange-50', 'dark:bg-orange-800'],
            ])

            // add the base classes to the title
            ->addClassToTitle('text-md font-medium')

            // change the text color depending on the type
            ->addClassToTitleForType([
                'error' => ['text-red-800', 'dark:text-red-50'],
                'info' => ['text-sky-800', 'dark:text-sky-50'],
                'success' => ['text-green-800', 'dark:text-green-50'],
                'warning' => ['text-orange-800', 'dark:text-orange-50'],
            ])

            ->addClassToIcon('flex-shrink-0 mr-3')
            ->addClassToIconForType([
                'error' => ['text-red-400', 'dark:text-red-50'],
                'info' => ['text-sky-400', 'dark:text-sky-50'],
                'success' => ['text-green-400', 'dark:text-green-50'],
                'warning' => ['text-orange-400', 'dark:text-orange-50'],
            ])

            ->addClassToContent('mt-2 text-sm')
            ->addClassToContentForType([
                'error' => ['text-red-700', 'dark:text-red-100'],
                'info' => ['text-sky-700', 'dark:text-sky-100'],
                'success' => ['text-green-700', 'dark:text-green-100'],
                'warning' => ['text-orange-700', 'dark:text-orange-100'],
            ]);
    }
}
