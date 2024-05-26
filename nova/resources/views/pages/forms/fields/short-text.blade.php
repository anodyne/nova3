@aware(['admin' => false])

@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

@if ($admin)
    <x-fieldset.field :label="$label" :description="$description" :id="$uid" :name="$name">
        <x-input.text :attributes="$attributesBag"></x-input.text>
    </x-fieldset.field>
@else
    <x-public::field.text
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        value="{{ $response }}"
        :attributes="$attributesBag"
    ></x-public::field.text>
@endif