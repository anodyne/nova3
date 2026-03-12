@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Illuminate\View\ComponentAttributeBag')
@use('Nova\Forms\Enums\FormType')

@php
    $options = data_get($attrs, 'options');
    unset($attrs['options']);

    $form ??= $this->getNovaForm();

    $uid = data_get($attrs, 'id');
    $label = data_get($details, 'label');
    $description = data_get($details, 'description');

    $hideWhenEmpty = data_get($details, 'hideWhenEmpty');
    $required = data_get($details, 'required');

    $errorKey = $form->type === FormType::Basic ? "values.{$uid}" : "{$form->key}.{$uid}";
    $error = $errors->getBag('default')->first($errorKey);

    $value = data_get($values, $uid);

    $inputName = $form ? $form?->key."[{$uid}]" : data_get($attrs, 'name');
@endphp

@if ($admin)
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-input.display :label="$label" :id="$uid">
                <x-text>
                    {{ filled($value) ? $value : '—' }}
                </x-text>
            </x-input.display>
        @endif
    @else
        <x-field>
            <x-label>{{ $label }}</x-label>

            <x-description>{{ $description }}</x-description>

            <x-radio.group :error="$error" :required="$required" :id="$uid">
                @foreach ((array) $options as $option)
                    @php
                        $attributesBag = new ComponentAttributeBag((array) data_get($option, 'attributes'));
                    @endphp

                    <x-radio
                        id="{{ data_get($attrs, 'name') }}_{{ data_get($option, 'value') }}"
                        :attributes="$attributesBag"
                        wire:model.live.debounce="values.{{ $uid }}"
                        :name="$inputName"
                        :value="data_get($option, 'value')"
                        :label="data_get($option, 'label')"
                        :description="data_get($option, 'description')"
                    />
                @endforeach
            </x-radio.group>

            <x-field.error :name="$errorKey" />
        </x-field>
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
        <x-public::field.radio-group :label="$label" :id="$uid" :description="$description" :required="$required">
            @foreach ((array) $options as $option)
                @php
                    $inputName = $form ? $form?->key."[{$uid}]" : data_get($option, 'name');

                    $option['name'] = $inputName;

                    $attributesBag = new ComponentAttributeBag((array) data_get($option, 'attributes'));
                @endphp

                <x-public::field.radio
                    :value="data_get($option, 'value')"
                    :label="data_get($option, 'label')"
                    :description="data_get($option, 'description')"
                    id="{{ $inputName }}_{{ data_get($option, 'value') }}"
                    :name="$inputName"
                    :attributes="$attributesBag"
                />
            @endforeach
        </x-public::field.radio-group>
    @endif
@endif
