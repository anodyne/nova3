<div>
    <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
        <button
            type="button"
            class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:text-gray-500 dark:hover:text-gray-400 dark:focus:ring-offset-gray-800"
            wire:click="dismiss"
        >
            <span class="sr-only">Close</span>
            <x-icon name="x" size="md"></x-icon>
        </button>
    </div>

    <x-content-box width="sm">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex shrink-0 items-center justify-center sm:mx-0">
                <x-badge :color="$theme">
                    <x-icon name="warning" size="md" class="shrink-0"></x-icon>
                </x-badge>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                    {{ $prompt['title'] }}
                </h3>
                <div class="mt-2">
                    <p class="text-gray-600 sm:text-sm dark:text-gray-400">{!! $prompt['message'] !!}</p>
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box
        class="z-20 space-y-4 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-y-0 sm:space-x-reverse"
        height="sm"
        width="sm"
    >
        <x-button wire:click="confirm" :color="$theme">
            {{ $prompt['confirm'] }}
        </x-button>

        <x-button wire:click="dismiss" type="button" plain>
            {{ $prompt['cancel'] }}
        </x-button>
    </x-content-box>
</div>
