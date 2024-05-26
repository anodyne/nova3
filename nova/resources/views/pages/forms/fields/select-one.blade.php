@aware(['admin' => false])

@use('Illuminate\View\ComponentAttributeBag')

@if ($admin)
    <x-fieldset.field :label="$label" :description="$description">
        <x-radio.group>
            @foreach ((array) $options as $option)
                @php
                    $attributesBag = new ComponentAttributeBag((array) data_get($option, 'attributes'));
                @endphp

                <x-radio.field>
                    @if (filled(data_get($option, 'label')))
                        <x-fieldset.label for="{{ $name }}_{{ data_get($option, 'value') }}">
                            {{ data_get($option, 'label') }}
                        </x-fieldset.label>
                    @endif

                    @if (filled(data_get($option, 'description')))
                        <x-fieldset.description>{{ data_get($option, 'description') }}</x-fieldset.description>
                    @endif

                    <x-radio
                        :value="data_get($option, 'value')"
                        id="{{ $name }}_{{ data_get($option, 'value') }}"
                        :attributes="$attributesBag"
                    ></x-radio>
                </x-radio.field>
            @endforeach
        </x-radio.group>
    </x-fieldset.field>
@else
    <x-public::field.radio-group :label="$label" :description="$description">
        @foreach ((array) $options as $option)
            @php
                $attributesBag = new ComponentAttributeBag((array) data_get($option, 'attributes'));
            @endphp

            <x-public::field.radio
                :name="$name"
                :value="data_get($option, 'value')"
                :label="data_get($option, 'label')"
                :description="data_get($option, 'description')"
                id="{{ $name }}_{{ data_get($option, 'value') }}"
                :attributes="$attributesBag"
            ></x-public::field.radio>
        @endforeach
    </x-public::field.radio-group>
@endif
