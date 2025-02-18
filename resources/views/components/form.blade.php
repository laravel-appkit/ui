<form {{ $attributes }}>
    <div class="space-y-6">
        @if (isset($errors) && $errors->any())
        <x-appkit::alert>{{ config('formulate.form_error_message') }}</x-appkit::alert>
        @endif

        {{ $slot }}
    </div>
</form>
