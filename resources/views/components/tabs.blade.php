@php
$activeTab = 'activeTab';
@endphp

<div
    x-data="{ {{ $activeTab }}: 1, totalTabs: null }"
    x-init="totalTabs = $refs.tablist.children.length; $watch('{{ $activeTab }}', value => $nextTick(() => $refs.tablist.children[{{ $activeTab }} - 1].querySelector('a').focus()))"
    >
    <nav class="border-b border-gray-200 mb-2" x-cloak>
        <ul
            role="tablist"
            aria-label="My Tabs"
            x-ref="tablist"
            class="-mb-px flex space-x-8"
            @keyup.right.prevent="({{ $activeTab }} < totalTabs) ? {{ $activeTab }}++ : {{ $activeTab }} = 1"
            @keyup.left.prevent="({{ $activeTab }} > 1) ? {{ $activeTab }}-- : {{ $activeTab }} = totalTabs"
            @keyup.down.prevent="({{ $activeTab }} < totalTabs) ? {{ $activeTab }}++ : {{ $activeTab }} = 1"
            @keyup.up.prevent="({{ $activeTab }} > 1) ? {{ $activeTab }}-- : {{ $activeTab }} = totalTabs"
            @keyup.home.prevent="{{ $activeTab }} = 1"
            @keyup.end.prevent="{{ $activeTab }} = totalTabs"
            >
            @foreach ($childComponents as $index => $child)
            <li role="presentation">
                <a
                    :aria-selected="{{ $activeTab }} == {{ $child->siblingIndex }}"
                    :class="{{ $activeTab }} == {{ $child->siblingIndex }} ? 'border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium' : ''"
                    :tabindex="{{ $activeTab }} == {{ $child->siblingIndex }} ? '0': '-1'"
                    @click.prevent="{{ $activeTab }} = {{ $child->siblingIndex }};"
                    aria-controls="tabpanel-1"
                    class="block border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                    href="#tab-{{ $child->siblingIndex }}"
                    id="tab-{{ $child->siblingIndex }}"
                    role="tab"
                    >
                    {{ $child->title }}
                </a>
            </li>
            @endforeach
        </ul>
    </nav>

    {{ $slot }}
</div>

<style>
[x-cloak] {
    display: none;
}
</style>
