<form {{ $attributes }}>
    <div class="space-y-6">
        @if (isset($errors) && $errors->any())
        <x-appkit::alert type="error" title="Error">
            {{ config('formulate.form_error_message') }}
            {{ dump($errors) }}
        </x-appkit::alert>
        @endif

        {{ $slot }}
    </div>
</form>
