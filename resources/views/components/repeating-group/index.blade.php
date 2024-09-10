{{-- class="space-y-3 w-full" --}}
<div {{ $attributes }}>
    <template x-for="(_, {{ $indexName }}) in {{ $source }}" :key='{{ $indexName }}'>
        {{ $slot }}
    </template>
</div>

@if ($addAnother)
    <x-appkit::repeating-group.add-another-button :$source />
@endif
