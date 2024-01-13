<x-dropdown max-height="15rem" width="sm">
    <x-slot name="selectTrigger">
        {{ $selected?->name ?? 'Select a rank name' }}
        <input type="hidden" name="name_id" value="{{ $selectedId }}" />
    </x-slot>

    <x-dropdown.group>
        <x-dropdown.search :search="$search" placeholder="Find a rank name..."></x-dropdown.search>
    </x-dropdown.group>

    <x-dropdown.group>
        @forelse ($filteredNames as $name)
            <x-dropdown.item wire:click="selectName({{ $name->id }})" class="w-full justify-between">
                <div class="flex items-center space-x-3">
                    <x-status :status="$name->status"></x-status>
                    <span>{{ $name->name }}</span>
                </div>

                <span
                    x-description="Checkmark, only display for selected option."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    @class([
                        'hidden' => $selectedId !== $name->id,
                        'flex items-center' => $selectedId === $name->id,
                        'text-primary-500' => $selectedId === $name->id && ! settings('appearance.panda'),
                        'text-gray-900 dark:text-white' => $selectedId === $name->id && settings('appearance.panda'),
                    ])
                >
                    <x-icon name="check" size="md"></x-icon>
                </span>
            </x-dropdown.item>
        @empty
            <div class="flex flex-col items-center pb-6 pt-2">
                <div class="text-base text-gray-500 dark:text-gray-400">There is no rank name named</div>
                <div class="mb-6 mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                    &lsquo;{{ $search }}&rsquo;
                </div>

                <x-button wire:click="createAndSelectName" type="button" color="neutral">Create this name</x-button>
            </div>
        @endforelse
    </x-dropdown.group>
</x-dropdown>
