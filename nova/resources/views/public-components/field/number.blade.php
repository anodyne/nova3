@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'name' => null,
])

<x-public::field :label="$label" :description="$description" :id="$id">
    <input
        type="number"
        inputmode="decimal"
        data-slot="control"
        id="{{ $id }}"
        name="{{ $name }}"
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
