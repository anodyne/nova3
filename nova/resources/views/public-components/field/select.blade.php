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
    <div data-slot="control" class="grid grid-cols-1">
        <select
            {{
                $attributes->class([
                    'nv-form-field-select',
                    'col-start-1 row-start-1 w-full appearance-none',
                    'rounded-lg py-2 pr-8 pl-3',
                    'text-base sm:text-sm/6',
                    'bg-white text-gray-900',
                    'outline-1 -outline-offset-1 outline-gray-300 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-600',
                    'dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus-visible:outline-blue-500',
                ])
            }}
        >
            {{ $slot }}
        </select>

        <svg
            viewBox="0 0 16 16"
            fill="currentColor"
            data-slot="icon"
            aria-hidden="true"
            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 dark:text-gray-400"
        >
            <path
                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd"
                fill-rule="evenodd"
            />
        </svg>
    </div>
</x-public::field>
