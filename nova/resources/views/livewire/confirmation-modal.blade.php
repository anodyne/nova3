<div>
    <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
        <button type="button" class="rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" wire:click="dismiss">
            <span class="sr-only">Close</span>
            <x-icon name="dismiss" size="md"></x-icon>
        </button>
    </div>

    <x-content-box width="sm">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex shrink-0 items-center justify-center sm:mx-0">
            <x-badge :color="$theme" size="circle" icon>
                <x-icon name="warning" size="md" class="shrink-0"></x-icon>
            </x-badge>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">{{ $prompt['title'] }}</h3>
            <div class="mt-2">
              <p class="sm:text-sm text-gray-600 dark:text-gray-400">{!! $prompt['message'] !!}</p>
            </div>
          </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse" height="sm" width="sm">
        <x-button.filled wire:click="confirm" :color="$theme">
            {{ $prompt['confirm'] }}
        </x-button.filled>

        <x-button.outline wire:click="dismiss" type="button" color="gray">
            {{ $prompt['cancel'] }}
        </x-button.outline>
    </x-content-box>
</div>
