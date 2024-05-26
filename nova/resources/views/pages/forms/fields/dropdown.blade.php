@aware(['admin' => false])

@use('Illuminate\View\ComponentAttributeBag')

@php
    $attributesBag = new ComponentAttributeBag((array) $attributes);
@endphp

@if ($admin)
    <x-fieldset.field :label="$label" :description="$description" :id="$uid" :name="$name">
        <x-select :attributes="$attributesBag">
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
@else
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
@endif
