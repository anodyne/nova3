@use('Illuminate\View\ComponentAttributeBag')

<div class="w-full max-w-2xl p-2">
    <x-public::field.radio-group :$label :$description>
        @foreach ((array) $options as $option)
            @php
                $attributesBag = new ComponentAttributeBag((array) $option['attributes']);
            @endphp

            <x-public::field.radio
                :name="$name"
                :value="data_get($option, 'value')"
                :label="data_get($option, 'label')"
                :description="data_get($option, 'description')"
                :attributes="$attributesBag"
            ></x-public::field.radio>
        @endforeach
    </x-public::field.radio-group>
</div>
