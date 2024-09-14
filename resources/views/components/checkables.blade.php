<x-appkit::fieldset :inheritedAttributes="$fieldsetAttributes" :legend="$label">
    <div {{ $attributes }}>
        @foreach ($options as $option)
            @php
            ['label' => $label, 'help' => $help, 'value' => $value] = $option;
            @endphp
            <x-dynamic-component :component="$itemComponentName" :$name :$id :$label :$help :$value />
        @endforeach
    </div>
</x-appkit::fieldset>
