<?php

namespace AppKit\UI;

use AppKit\UI\Components\BaseComponent;
use AppKit\UI\Contracts\StyleFramework;
use AppKit\UI\Styles\Tailwind\Tailwind;

class UI
{
    private $app;

    /**
     * An array of components which have been initialised
     * @var array
     */
    private $initializedComponents = [];

    public function __construct()
    {
        $this->app = app();
    }

    /**
     * Get the instance of the style framework
     *
     * @return StyleFramework
     */
    private function getStyleFramework(): StyleFramework
    {
        // TODO: Turn this into something configurable
        $style = Tailwind::class;

        // get an instance of the framework
        return new $style();
    }

    /**
     * Get the customisations for a particular component
     *
     * @param string $component
     * @return void
     */
    public function loadCustomizationsForComponent(string $component)
    {
        // get the name of the styler class
        $componentStylerClass = $this->getStyleFramework()->locateStylerForComponent($component);

        // check that we do have a styler class
        if ($componentStylerClass) {
            // create an instance of it
            $componentCustomizations = new $componentStylerClass();

            // and pass it to the component as a customizer
            $component::customize($componentCustomizations);
        }
    }

    /**
     * Start rendering a component
     *
     * @param BaseComponent $component
     * @return void
     */
    public function startComponent(BaseComponent $component)
    {
        // check if we haven't already got this component class in the initialized components
        if (!in_array($component::class, $this->initializedComponents)) {
            // load the component customizations
            $this->loadCustomizationsForComponent($component::class);

            // add the component to the list of initialized components
            $this->initializedComponents[] = $component::class;
        }
    }

    public function id($id)
    {
        return $this->app->get(Id::class)->for($id);
    }
}
