@if (!$href)
<button {{ $attributes }}>{{ $slot }}</button>
@else
<a href="{{ $href }}" {{ $attributes }}>{{ $slot }}</a>
@endif
