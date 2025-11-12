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
                'block w-full text-base sm:text-sm/6',
                'rounded-lg bg-white px-3 py-2',
                'outline-1 -outline-offset-1 outline-gray-300',
                'text-gray-900 placeholder:text-gray-400',
                'focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600',
                'dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-blue-500',
            ])
        }}
    />
</x-public::field>
