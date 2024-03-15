@php
    $id = $childComponents->first()->id;
@endphp

<div class="col-span-full">
    <x-appkit::label for="{{ $id }}" :$label />

    {{ $slot }}

    @if ($error)
    <x-appkit::field-error :$error />
    @endif

    <x-appkit::help-text :$help />
</div>
