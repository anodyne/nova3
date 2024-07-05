@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'name' => null,
])

<x-public::field :label="$label" :description="$description" :id="$id">
    <div data-slot="control" class="relative w-full">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            {{
                $attributes->class([
                    'nv-form-field-select',
                    'w-full rounded-lg border',
                    'border-gray-300 bg-white text-gray-900',
                    'dark:border-gray-700 dark:bg-gray-800 dark:text-white',
                ])
            }}
        >
            {{ $slot }}
        </select>

        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
            <svg
                class="size-5 stroke-gray-500 group-has-[[data-disabled]]:stroke-gray-600 dark:stroke-gray-400 sm:size-4 forced-colors:stroke-[CanvasText]"
                viewBox="0 0 16 16"
                aria-hidden="true"
                fill="none"
            >
                <path
                    d="M5.75 10.75L8 13L10.25 10.75"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path d="M10.25 5.25L8 3L5.75 5.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
    </div>
</x-public::field>
