@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Illuminate\View\ComponentAttributeBag')
@use('Nova\Forms\Enums\FormType')

@php
    $attrs = array_merge(
        $attrs,
        $attrs['other'] ?? []
    );

    $options = data_get($attrs, 'options') ?? [];

    unset($attrs['options']);
    unset($attrs['other']);

    $form ??= $this->getNovaForm();

    $uid = data_get($attrs, 'id');
    $label = data_get($details, 'label');
    $description = data_get($details, 'description');

    $hideWhenEmpty = data_get($details, 'hideWhenEmpty');
    $required = data_get($details, 'required');

    $inputName = $form ? $form?->key."[{$uid}]" : data_get($attrs, 'name');

    $attrs['name'] = $inputName;

    $attributesBag = new ComponentAttributeBag((array) $attrs);

    $errorKey = $form->type === FormType::Basic ? "values.{$uid}" : "{$form->key}.{$uid}";
    $error = $errors->getBag('default')->first($errorKey);

    $value = data_get($values, $uid);
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
        <x-fieldset.field
            :label="$label"
            :description="$description"
            :id="$uid"
            :name="$inputName"
            :error="$error"
            :required="$required"
        >
            <x-select :attributes="$attributesBag" wire:model.live.debounce="values.{{ $uid }}">
                @if ($attributesBag->has('placeholder'))
                    <option value="">{{ $attributesBag->get('placeholder') }}</option>
                @endif

                @foreach ((array) $options as $value => $text)
                    <option value="{{ $value }}">
                        {{ $text }}
                    </option>
                @endforeach
            </x-select>
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
        <x-public::field.select
            :label="$label"
            :description="$description"
            :required="$required"
            :attributes="$attributesBag"
            wire:model.live.debounce="values.{{ $uid }}"
        >
            @if ($attributesBag->has('placeholder'))
                <option value="">{{ $attributesBag->get('placeholder') }}</option>
            @endif

            @foreach ((array) $options as $value => $text)
                <option value="{{ $value }}">
                    {{ $text }}
                </option>
            @endforeach
        </x-public::field.select>
    @endif
@endif
