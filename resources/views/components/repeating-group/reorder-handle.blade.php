{{-- class="w-9 flex items-center cursor-move" --}}
<div
    @mousedown="draggable = true"
    @touchstart="draggable = true"
    @mouseup="draggable = false"
    @touchend="draggable = false"
    {{ $attributes }}
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
    </svg>
</div>
