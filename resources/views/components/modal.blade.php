<div
    x-cloak
    @keydown.window.escape="{{ $close() }}"
    x-show="{{ $isOpen() }}"
    class="relative z-10"
    aria-labelledby="modal-title"
    aria-modal="true"
>
    <!-- Modal Backdrop -->
    <div
        x-show="{{ $isOpen() }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                x-show="{{ $isOpen() }}"
                x-trap.inert.noscroll.noautofocus="{{ $isOpen() }}"
                x-transition:enter="ease-out duration-3000"
                x-transition:enter-start="opacity-0 -translate-y-4 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                @click.away="{{ $close() }}"
                >
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    {{ $slot }}
                </div>

                <!-- Modal Buttons -->
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" @click="{{ $close() }}">Deactivate</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="{{ $close() }}">Cancel</button>
                </div>
                <!-- / Modal Buttons -->
            </div>
        </div>
    </div>
</div>
