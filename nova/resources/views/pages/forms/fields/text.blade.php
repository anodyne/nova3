<x-fieldset.field>
    @if (filled($label))
        <x-fieldset.label>{{ $label }}</x-fieldset.label>
    @endif

    @if (filled($description))
        <x-fieldset.description>{{ $description }}</x-fieldset.description>
    @endif

    <x-input.text :type="$type" :placeholder="data_get($attributes, 'placeholder')"></x-input.text>
</x-fieldset.field>
