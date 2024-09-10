<div
    :draggable="draggable"
    @dragstart="draggingIndex = index; $event.dataTransfer.setData('text/plain', index);"
    @dragend="draggingIndex = null; droppingIndex = null;"
    :class="{'opacity-50': draggingIndex === index, 'pt-10 bg-indigo-500': droppingIndex == index && draggingIndex > index, 'pb-10 bg-blue-500': droppingIndex == index && draggingIndex < index}"
    class="relative transition-spacing duration-300 ease-in-out"
>
    {{ $slot }}

    <div
        class="absolute inset-0 opacity-60 cursor-move transition-spacing duration-300 ease-in-out z-10"
        x-show.transition="draggingIndex !== null"
        @dragenter.prevent="droppingIndex = index"
        @dragleave="if (index === droppingIndex) { droppingIndex = null; }"
        @drop.prevent="{{ $source }}.splice(droppingIndex, 0, {{ $source }}.splice(draggingIndex, 1)[0]); draggable = false; $nextTick(() => { form.validate(); });"
        @dragover.prevent="$event.dataTransfer.dropEffect = 'move'"
    >
    </div>
</div>
