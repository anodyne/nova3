@aware(['admin' => false])

@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

@if ($admin)
    <x-fieldset.field :label="$label" :description="$description" :id="$uid" :name="$name">
        <x-input.number :attributes="$attributesBag"></x-input.number>
    </x-fieldset.field>
@else
    <x-public::field.number
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        :attributes="$attributesBag"
    ></x-public::field.number>
@endif
