@idBlock($id)

<div class="relative flex gap-x-3">
    <div class="flex h-6 items-center">
        <x-appkit::input type="checkbox" id="{{ UI::id($id) }}" :$name :$value />
    </div>

    <div class="text-sm leading-6">
        <x-appkit::label for="{{ UI::id($id) }}" text="{{ $label }}" />

        @if ($help)
        <x-appkit::help-text text="{{ $help }}" />
        @endif
    </div>
</div>

@endIdBlock()
