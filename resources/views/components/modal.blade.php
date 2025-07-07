<dialog {{ $attributes }}>
    <div tabindex="-1">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            {{ $slot }}
        </div>

        @if (!empty($actions))
        <div class="bg-gray-200 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            {{ $actions }}
        </div>
        @endif
    </div>
</dialog>
