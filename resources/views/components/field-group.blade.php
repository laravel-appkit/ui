@php
    $id = $childComponents[0]->id;
@endphp

<div class="col-span-full">
    <x-appkit::label for="{{ $id }}" :text="$label" />

    <div class="mt-2">
        {{ $slot }}
    </div>

    <div class="mt-3">
        <x-appkit::help-text :text="$help" />
    </div>
</div>
