@php
    $id = $childComponents[0]->id;
@endphp

<div class="col-span-full">
    <x-appkit::label for="{{ $id }}" :text="$label" />

    <div class="mt-2">
        {{ $slot }}
    </div>

    @if ($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif

    <x-appkit::help-text :text="$help" />
</div>
