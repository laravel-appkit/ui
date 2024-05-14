<div id="tabpanel-{{ $siblingIndex }}" role="tabpanel" tabindex="0" aria-labelledby="tab-{{ $siblingIndex }}" x-show="activeTab == {{ $siblingIndex }}">
    <h2 class="mb-8 lg:mb-3 font-semibold text-slate-900 dark:text-slate-200" x-show="false">{{ $title }}</h2>

    {{ $slot }}
</div>
