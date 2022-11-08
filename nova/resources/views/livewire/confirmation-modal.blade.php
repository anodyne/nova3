<div>
    <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
        <button type="button" class="rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" wire:click="dismiss">
            <span class="sr-only">Close</span>
            @icon('close', 'h-6 w-6')
        </button>
    </div>

    <x-content-box width="sm">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex shrink-0 items-center justify-center sm:mx-0">
            <x-badge :color="$theme" size="circle" icon>
                @icon('warning', 'h-6 w-6 shrink-0')
            </x-badge>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modal-title">{{ $prompt['title'] }}</h3>
            <div class="mt-2">
              <p class="sm:text-sm text-gray-600 dark:text-gray-400">{!! $prompt['message'] !!}</p>
            </div>
          </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse" height="sm" width="sm">
        <x-button wire:click="confirm" :color="$theme">
            {{ $prompt['confirm'] }}
        </x-button>

        <x-button wire:click="dismiss" type="button" color="white">
            {{ $prompt['cancel'] }}
        </x-button>
    </x-content-box>
</div>
