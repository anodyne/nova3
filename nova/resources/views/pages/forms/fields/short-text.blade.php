@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Illuminate\View\ComponentAttributeBag')
@use('Nova\Forms\Enums\FormType')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);

    $inputName = $form ? $form?->key."[{$uid}]" : $name;

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
        >
            <x-input.text :attributes="$attributesBag" wire:model.live.debounce="values.{{ $uid }}"></x-input.text>
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
        <x-public::field.text
            :label="$label"
            :description="$description"
            :id="$uid"
            :name="$inputName"
            :attributes="$attributesBag"
            wire:model.live.debounce="values.{{ $uid }}"
        ></x-public::field.text>
    @endif
@endif
