@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'name' => null,
    'error' => null,
])

@aware(['form' => null])

@php
    if (filled($form)) {
        $errorKey = "{$form->key}.{$id}";
        $error = $errors->getBag('default')->first($errorKey);
    }
@endphp

<x-public::field :$label :$description :$id :$error>
    <input
        type="email"
        inputmode="email"
        data-slot="control"
        id="{{ $id }}"
        name="{{ $name }}"
        {{
            $attributes->class([
                'nv-form-field-email',
                'rounded-lg border',
                'border-gray-300 bg-white text-gray-900',
                'dark:border-gray-700 dark:bg-gray-800 dark:text-white',
            ])
        }}
    />
</x-public::field>
