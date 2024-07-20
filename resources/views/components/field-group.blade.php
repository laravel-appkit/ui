@php
    $id = 'smee';
    // $id = $childComponents->first()->id;
@endphp

<div class="space-y-2">
    <x-appkit::label for="{{ $id }}" :$label />

    <div>
        {{ $slot }}
    </div>

    @if ($error)
    <x-appkit::field-error :$error />
    @endif

    @if ($help)
    <x-appkit::help-text :$help />
    @endif
</div>
