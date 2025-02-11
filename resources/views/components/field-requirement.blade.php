@if ($required && !$highlightOptionalFields)<span {{ $attributes }}>{{ $requiredText }}</span>@endif
@if (!$required && $highlightOptionalFields)<span {{ $attributes }}>{{ $optionalText }}</span>@endif
