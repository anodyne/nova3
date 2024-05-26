@aware(['admin' => false])

@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

@if ($admin)
    <x-fieldset.field :label="$label" :description="$description" :id="$uid" :name="$name">
        <x-input.email :attributes="$attributesBag"></x-input.email>
    </x-fieldset.field>
@else
    <x-public::field.email
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        :attributes="$attributesBag"
    ></x-public::field.email>
@endif
