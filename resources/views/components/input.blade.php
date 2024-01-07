<div {{ $wrapperElement }}>
    @if (!empty($prefix))
        <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">{{ $prefix }}</span>
    @endif

    <input {{ $attributes }} />

    @if (!empty($postfix))
        <span class="flex select-none items-center pr-3 text-gray-500 sm:text-sm">{{ $postfix }}</span>
    @endif
</div>
