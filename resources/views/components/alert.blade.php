@use(Illuminate\View\ComponentSlot)

<div {{ $attributes }}>
    <div class="flex {{ $slot->isEmpty() ? 'items-center' : '' }}">
        {{-- An icon, can be defined as a name (to pass to the icon component), or as a slot --}}
        @if (!empty($icon))
            <div {{ $iconAttributes }}>
                @if ($icon instanceof ComponentSlot)
                    {{ $icon }}
                @else
                    <x-appkit::icon :$icon />
                @endif
            </div>
        @endif

        {{-- Container to store the title, content etc --}}
        <div>
            {{-- A title can be defined as an attribute or a slot --}}
            @if ($title)
                @if ($title instanceof ComponentSlot)
                    {{ $title }}
                @else
                    <h3 {{ $titleAttributes }}>{{ $title }}</h3>
                @endif
            @endif

            {{--  Content will always come in as a slot, but could be empty --}}
            @if ($slot->isNotEmpty())
            <div {{ $contentAttributes }}>
                {{ $slot }}
            </div>
            @endif
        </div>
    </div>
</div>
