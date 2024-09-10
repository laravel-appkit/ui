<x-appkit::button @click.prevent="{{ $source }}.splice(index - 1, 0, {{ $source }}.splice(index, 1)[0]);" ::disabled="index == 0">
    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-4 h-4'>
        <path stroke-linecap='round' stroke-linejoin='round' d='M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18' />
    </svg>
</x-appkit::button>

<x-appkit::button @click.prevent="{{ $source }}.splice(index + 1, 0, {{ $source }}.splice(index, 1)[0]);" ::disabled="index == {{ $source }}.length - 1">
    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-4 h-4'>
        <path stroke-linecap='round' stroke-linejoin='round' d='M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3' />
    </svg>
</x-appkit::button>
