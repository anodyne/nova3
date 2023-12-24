@props([
    'label' => false,
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="relative inline-flex items-center space-x-2">
    <div class="relative">
        <input
            type="checkbox"
            class="peer relative m-0 block size-4 cursor-pointer appearance-none rounded border-none bg-white p-0 outline-none ring-1 ring-gray-300 transition-shadow duration-300 focus:checked:ring-[5px] focus:checked:ring-primary-100 dark:bg-gray-800 dark:ring-gray-200/[15%] dark:checked:ring-primary-900"
            {{ $attributes->merge(['id' => $for]) }}
            @checked($checked)
        />

        <svg
            class="pointer-events-none absolute left-0 top-0 block size-4 scale-0 transform rounded bg-primary-100 text-primary-600 ring-1 ring-primary-600 transition focus:outline-none peer-checked:scale-100 dark:bg-primary-900 dark:text-primary-500 dark:ring-primary-500"
            viewBox="0 0 21 21"
            fill="none"
            stroke-width="2.5"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke="currentColor"
        >
            <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
        </svg>
    </div>

    @if ($label)
        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
    @endif
</label>
