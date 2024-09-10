<form {{ $attributes }}>
    <div class="space-y-6">
        @if (isset($errors) && $errors->any())
        <div class="{{ config('formulate.classes.form_error') }}">{{ config('formulate.form_error_message') }}</div>
        @endif

        {{ $slot }}
    </div>
</form>
