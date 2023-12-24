@props([
    'label' => false,
    'for' => false,
    'checked' => false,
    'help' => false,
])

<label class="flex items-center space-x-2" for="{{ $for }}">
    <div class="relative">
        <input
            type="checkbox"
            id="{{ $for }}"
            {{ $attributes->merge(['class' => 'peer sr-only']) }}
            @checked($checked)
        />

        <div
            class="size-4 rounded border-[1.5px] border-gray-300 bg-white peer-checked:border-primary-500 peer-checked:bg-primary-100 dark:border-gray-200/[15%] dark:bg-gray-800"
        ></div>

        <svg
            viewBox="0 0 16 16"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
            class="absolute left-0 top-0 hidden size-4 text-primary-500 peer-checked:block"
        >
            <path
                d="M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z"
            />
        </svg>
    </div>

    @if ($label)
        <div {{ $label->attributes->merge(['class' => 'text-sm font-medium']) }}>
            {{ $label }}
        </div>
    @endif
</label>
