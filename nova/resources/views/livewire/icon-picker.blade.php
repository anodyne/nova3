<x-dropdown max-height="15rem" width="sm">
    <x-slot name="selectTrigger">
        @if (filled($selected))
            <div class="flex items-center gap-x-2">
                <x-icon :name="$selected" size="lg" class="shrink-0"></x-icon>
                <span>{{ $selected }}</span>
            </div>
        @else
            Select an icon
        @endif
        <input type="hidden" name="icon" value="{{ $selected }}" />
    </x-slot>

    <x-dropdown.group>
        <x-dropdown.search :search="$search" placeholder="Find an icon..."></x-dropdown.search>
    </x-dropdown.group>

    <x-dropdown.group>
        @if (count($icons) > 0)
            <div class="flex flex-wrap">
                <div class="flex items-center justify-center">
                    <button
                        type="button"
                        wire:click="selectIcon('')"
                        class="group flex w-full flex-col items-center rounded-md px-4 py-2 text-xs font-medium leading-tight text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100"
                    >
                        <span class="h-8 w-8 shrink-0">
                            No
                            <br />
                            icon
                        </span>
                    </button>
                </div>

                @foreach ($icons as $icon => $value)
                    <div class="flex items-center justify-center">
                        <button
                            wire:click="selectIcon('{{ $icon }}')"
                            type="button"
                            class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none md:text-sm dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100"
                            role="menuitem"
                        >
                            <x-icon :name="$icon" size="xl" class="shrink-0"></x-icon>
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-4">
                <div class="text-center leading-normal">
                    <div class="text-gray-500 dark:text-gray-400">No icons found with the name</div>
                    <div class="mt-1 font-medium text-gray-900 dark:text-white">&lsquo;{{ $search }}&rsquo;</div>
                </div>
            </div>
        @endif
    </x-dropdown.group>
</x-dropdown>
