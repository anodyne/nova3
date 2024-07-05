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
            <x-input.number :attributes="$attributesBag" wire:model.live.debounce="values.{{ $uid }}"></x-input.number>
        </x-fieldset.field>
    @endif
@else
    <x-public::field.number
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$inputName"
        :attributes="$attributesBag"
        wire:model.live.debounce="values.{{ $uid }}"
    ></x-public::field.number>
@endif
