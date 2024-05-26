@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

<div class="w-full max-w-2xl p-2">
    <x-public::field.text
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        :attributes="$attributesBag"
    ></x-public::field.text>
</div>
