@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

<div class="w-full max-w-2xl p-2">
    <x-public::field.select
        :label="$label"
        :description="$description"
        :id="$uid"
        :name="$name"
        :attributes="$attributesBag"
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
</div>
