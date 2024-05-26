@aware(['admin' => false])

@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

@if ($admin)
    <x-fieldset.field :label="$label" :description="$description" :id="$uid" :name="$name">
        <x-input.textarea :rows="$rows" :attributes="$attributesBag"></x-input.textarea>
    </x-fieldset.field>
@else
    <x-public::field.textarea
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        :rows="$rows"
        :attributes="$attributesBag"
    ></x-public::field.textarea>
@endif
