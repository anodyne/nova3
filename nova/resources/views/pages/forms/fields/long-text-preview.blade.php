@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

<div class="w-full max-w-2xl p-2">
    <x-public::field.textarea
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        :rows="$rows"
        :attributes="$attributesBag"
    ></x-public::field.textarea>
</div>
