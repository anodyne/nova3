<div>
    <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
        <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" wire:click="dismiss">
            <span class="sr-only">Close</span>
            @icon('close', 'h-6 w-6')
        </button>
    </div>

    <x-content-box width="sm">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex shrink-0 items-center justify-center sm:mx-0">
            <x-badge :color="$theme" size="circle">
                @icon('warning', 'h-6 w-6 shrink-0')
            </x-badge>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modal-title">{{ $prompt['title'] }}</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-600 dark:text-gray-400">{!! $prompt['message'] !!}</p>
            </div>
          </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button wire:click="confirm" :color="$theme" full-width>
            {{ $prompt['confirm'] }}
        </x-button>

        <x-button wire:click="dismiss" type="button" color="white" full-width>
            {{ $prompt['cancel'] }}
        </x-button>
    </x-content-box>
</div>
