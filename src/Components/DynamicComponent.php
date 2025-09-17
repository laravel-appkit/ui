<?php

namespace AppKit\UI\Components;

use Illuminate\Support\Collection;
use Illuminate\View\DynamicComponent as BaseDynamicComponent;
use Override;

class DynamicComponent extends BaseDynamicComponent
{
    /**
     * The data that should be passed to this component
     *
     * @var array
     */
    public array $data;

    /**
     * Create a Dynamic Component
     *
     * @param string $componentName
     * @param array $slotContent
     */
    public function __construct(
        string $componentName,
        public array|Collection $slotContent = []
    )
    {
        // store the component name that we want to generate
        $this->component = $componentName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    #[Override]
    public function render()
    {
        $template = <<<'EOF'
<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
{{ props }}
<x-{{ component }} {{ bindings }} {{ attributes }}>
{{ slots }}
{{ defaultSlot }}
</x-{{ component }}>
EOF;

        return function ($data) use ($template) {
            $this->parseComponentData($data);

            $bindings = $this->bindings($class = $this->classForComponent());

            return str_replace(
                [
                    '{{ component }}',
                    '{{ props }}',
                    '{{ bindings }}',
                    '{{ attributes }}',
                    '{{ slots }}',
                    '{{ defaultSlot }}',
                ],
                [
                    $this->component,
                    $this->compileProps($bindings),
                    $this->compileBindings($bindings),
                    class_exists($class) ? '{{ $attributes }}' : '',
                    $this->compileSlots($this->data['__laravel_slots'], $this->data),
                    $this->compileDefaultSlot($this->data['__laravel_slots']),
                ],
                $template
            );
        };
    }

    protected function parseComponentData(array $data): void
    {
        $data['__laravel_slots'] = $data['slotContent']->toArray();

        unset($data['slotContent']);

        foreach ($data['__laravel_slots'] as $name => $content) {
            if ($name != '__default') {
                $data[$name] = $content;
            }
        }

        $this->data = $data;
    }

    /**
     * Compile the default slot for the component.
     *
     * @param  array  $slots
     * @return string
     */
    protected function compileDefaultSlot(array $slots): string
    {
        if (!array_key_exists('__default', $slots)) {
            return '';
        }

        return $slots['__default'];
    }

    /**
     * Compile the slots for the component.
     *
     * @param  array  $slots
     * @return string
     */
    protected function compileSlots(array $slots): ?string
    {
        return collect($slots)->map(function ($slot, $name) {
            return $name === '__default' ? null : '<x-slot name="'.$name.'" '.((string) $slot->attributes).'>'.$this->data[$name].'</x-slot>';
        })->filter()->implode(PHP_EOL);
    }
}
