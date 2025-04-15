<div class="bg-gray-100 dark:bg-gray-900">
    <div class="grid grid-cols-[15%_minmax(0,1fr)_15%] grid-rows-[auto_1fr_auto] [grid-template-areas:'header_header_header''sidebar_main_aside''sidebar_footer_aside'] min-h-screen">
        <div class="[grid-area:header] sticky top-0 z-100">
            {{ $header ?? '' }}
        </div>

        <div class="[grid-area:main]">
            <div class="p-8">{{ $slot ?? '' }}</div>
        </div>

        <div class="[grid-area:footer] p-6 text-white bg-white dark:bg-gray-800 shadow-sm border-t border-gray-100 dark:border-gray-700">
            {{ $footer ?? '' }}
        </div>

        <div class="[grid-area:sidebar] overflow-y-auto overscroll-contain flex flex-col gap-4 p-4 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700" x-data x-bind:style="{ position: 'sticky', top: $el.offsetTop + 'px', 'max-height': 'calc(100dvh - ' + $el.offsetTop + 'px)' }">
            {{ $sidebar ?? '' }}
        </div>

        <div class="[grid-area:aside] flex flex-col gap-4 p-4 bg-white dark:bg-gray-800 border-l text-white border-gray-200 dark:border-gray-700" x-data x-bind:style="{ position: 'sticky', top: $el.offsetTop + 'px', 'max-height': 'calc(100dvh - ' + $el.offsetTop + 'px)' }">
            <div class="p-4">{{ $aside ?? 'Empty Aside' }}</div>
        </div>
    </div>
</div>
