@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Illuminate\View\ComponentAttributeBag')
@use('Nova\Forms\Enums\FormType')

@php
    $errorKey = $form->type === FormType::Basic ? "values.{$uid}" : "{$form->key}.{$uid}";
    $error = $errors->getBag('default')->first($errorKey);

    $value = data_get($values, $uid);

    $inputName = $form ? $form?->key."[{$uid}]" : $name;
@endphp

@if ($admin)
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-fieldset.field :label="$label" :id="$uid">
                <x-text>
                    {{ filled($value) ? $value : '—' }}
                </x-text>
            </x-fieldset.field>
        @endif
    @else
        <x-fieldset.field :label="$label" :description="$description">
            <x-radio.group :error="$error">
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
                            <x-fieldset.description>
                                {{ data_get($option, 'description') }}
                            </x-fieldset.description>
                        @endif

                        <x-radio
                            id="{{ $name }}_{{ data_get($option, 'value') }}"
                            :attributes="$attributesBag"
                            wire:model.live.debounce="values.{{ $uid }}"
                            :name="$inputName"
                            :value="data_get($option, 'value')"
                        ></x-radio>
                    </x-radio.field>
                @endforeach
            </x-radio.group>
        </x-fieldset.field>
    @endif
@else
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-public::field :label="$label">
                <div data-slot="text">
                    {{ filled($value) ? $value : '—' }}
                </div>
            </x-public::field>
        @endif
    @else
        <x-public::field.radio-group :label="$label" :description="$description">
            @foreach ((array) $options as $option)
                @php
                    $attributesBag = new ComponentAttributeBag((array) data_get($option, 'attributes'));
                    $inputName = $form ? $form?->key."[{$uid}]" : $name;
                @endphp

                <x-public::field.radio
                    :name="$inputName"
                    :value="data_get($option, 'value')"
                    :label="data_get($option, 'label')"
                    :description="data_get($option, 'description')"
                    id="{{ $name }}_{{ data_get($option, 'value') }}"
                    :attributes="$attributesBag"
                ></x-public::field.radio>
            @endforeach
        </x-public::field.radio-group>
    @endif
@endif
