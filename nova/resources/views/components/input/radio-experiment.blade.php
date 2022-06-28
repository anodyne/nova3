@props([
    'label' => false,
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <div class="relative">
        <input
            type="radio"
            class="peer relative m-0 block h-4 w-4 cursor-pointer appearance-none rounded-full border-none bg-white dark:bg-gray-800 p-0 outline-none ring-1 ring-gray-300 dark:ring-gray-200/[15%] transition-shadow duration-300 focus:checked:ring-[5px] focus:checked:ring-primary-100 dark:checked:ring-primary-900"
            {{ $attributes->merge(['id' => $for]) }}
            @checked($checked)
        >

        <svg class="pointer-events-none absolute top-0 left-0 block h-4 w-4 scale-0 transform rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-500 ring-1 ring-primary-600 dark:ring-primary-500 transition peer-checked:scale-100 focus:outline-none" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><circle cx="8" cy="8" r="3"/></svg>
    </div>

    @if ($label)
        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $label }}</span>
    @endif
</label>
