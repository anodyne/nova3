@use('Illuminate\View\ComponentAttributeBag')

<x-fieldset.field-group class="p-2" constrained-lg>
    <x-fieldset.field>
        @if (filled($label))
            <x-fieldset.label>{{ $label }}</x-fieldset.label>
        @endif

        @if (filled($description))
            <x-fieldset.description>{{ $description }}</x-fieldset.description>
        @endif

        <x-dynamic-component
            :component="
                match ($type) {
                    'email' => 'public::field.email',
                    'number' => 'public::field.number',
                    'password' => 'public::field.password',
                    default => 'public::field.text'
                }
            "
            :attributes="new ComponentAttributeBag($attributes)"
        ></x-dynamic-component>
    </x-fieldset.field>
</x-fieldset.field-group>
