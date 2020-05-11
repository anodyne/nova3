@props(['title'])

{{-- <button
    x-data="{ id: {{ $itemId }} }"
    x-on:click="$dispatch('open-modal', { id })"
    type="button"
    {{ $attributes->merge(['class' => 'button']) }}
>
    {{ $trigger }}
</button> --}}

@push('modal')
<div
    x-data="{ open: false, id: 0 }"
    x-on:open-modal.window="open = true; id = $event.detail.id"
    x-show="open"
    x-cloak
    class="fixed z-20 bottom-0 inset-x-0 px-4 pb-4 | sm:inset-0 sm:flex sm:items-center sm:justify-center"
>
    <div
        x-show="open"
        x-description="Background overlay, show/hide based on modal state."
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 transition-opacity"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
        x-show="open"
        x-description="Modal panel, show/hide based on modal state."
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative z-30 bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all | sm:max-w-lg sm:w-full sm:p-6"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
    >
        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
            <button
                x-on:click="open = false; $dispatch('close-modal', { id })"
                type="button"
                class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150"
                aria-label="Close"
            >
                @icon('close', 'h-6 w-6')
            </button>
        </div>
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 | sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    {{ $title }}
                </h3>
                <div class="mt-2">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button
                    x-on:click="open = false; $dispatch('close-modal', { id })"
                    type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 | sm:text-sm sm:leading-5"
                >
                    Deactivate
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm | sm:mt-0 sm:w-auto">
                <button
                    x-on:click="open = false; $dispatch('close-modal', { id })"
                    type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 | sm:text-sm sm:leading-5"
                >
                    Cancel
                </button>
            </span>
        </div>
    </div>
</div>
@endpush
