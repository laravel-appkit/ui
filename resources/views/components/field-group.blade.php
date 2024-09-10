@php
    $id = 'smee';
@endphp

<div {{ $attributes }}>
    <x-appkit::label for="{{ $id }}" :$label {{ $labelElement }} />

    <div {{ $inputWrapperElement }}>
        {{ $slot }}
    </div>

    <x-appkit::field-error :$name :$error {{ $errorElement }} />

    @if ($help)
    <x-appkit::help-text :$help {{ $helpElement }} />
    @endif
</div>
