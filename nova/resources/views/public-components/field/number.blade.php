@props([
    'label' => null,
    'description' => null,
    'error' => null,
    'required' => null,
])

@aware(['form' => null])

@php
    if (filled($form)) {
        $id = data_get($attributes, 'id');

        $errorKey = "{$form->key}.{$id}";
        $error = $errors->getBag('default')->first($errorKey);
    }
@endphp

<x-public::field :$label :$description :id="data_get($attributes, 'id')" :$error :$required>
    <input
        type="number"
        inputmode="decimal"
        data-slot="control"
        {{
            $attributes->class([
                'nv-form-field-number',
                'rounded-lg border',
                'border-gray-300 bg-white text-gray-900',
                'dark:border-gray-700 dark:bg-gray-800 dark:text-white',
            ])
        }}
    />
</x-public::field>
