@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'name' => null,
    'rows' => null,
])

<x-public::field :label="$label" :description="$description">
    <textarea
        data-slot="control"
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{
            $attributes->class([
                'nv-form-field-textarea',
                'rounded-lg border',
                'border-gray-300 bg-white text-gray-900',
                'dark:border-gray-700 dark:bg-gray-800 dark:text-white',
            ])
        }}
    ></textarea>
</x-public::field>
