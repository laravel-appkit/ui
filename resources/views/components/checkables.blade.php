<x-appkit::fieldset legend="My Legend">
    <div class="mt-3 space-y-6">
        @foreach ($options as $option)
            <x-dynamic-component :component="$itemComponentName" name="example" id="{{ $id }}" label="{{ $option['label'] }}" help="{{ $option['help'] }}" value="{{ $option['value'] }}" />
        @endforeach
    </div>
</x-appkit::fieldset>
