@php
    $id = 'smee';
@endphp

<div {{ $attributes }}>
    <x-appkit::label for="{{ $id }}" :$label :$required {{ $labelAttributes }} />

    <div {{ $fieldAttributes }}>
        {{ $slot }}
    </div>

    <x-appkit::field-error :$name :$error {{ $errorAttributes }} />

    @if ($help)
    <x-appkit::help-text :$help {{ $helpAttributes }} />
    @endif
</div>
