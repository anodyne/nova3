<div class="leading-0">
    @can('update', $story)
        <x-dropdown wide>
            <x-slot name="trigger">
                <x-badge :color="$story->status->color()" size="xs">
                    @if ($story->canPost)
                        <x-slot name="leadingIcon">
                            @icon('edit', $component->iconStyles())
                        </x-slot>
                    @endif

                    {{ $story->status->displayName() }}

                    <x-slot name="trailingIcon">
                        <svg class="{{ $component->iconStyles() }} -mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </x-slot>
                </x-badge>
            </x-slot>

            <x-dropdown.group>
                <x-dropdown.item type="button" wire:click="updateStatus('upcoming')">
                    <div class="flex items-center justify-between w-full">
                        <span>Upcoming</span>
                        @if (Str::contains($story->status, 'Upcoming'))
                            @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                        @endif
                    </div>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="updateStatus('current')">
                    <div class="flex items-center justify-between w-full">
                        <span>Current (with posting)</span>
                        @if (Str::contains($story->status, 'Current') && $story->allow_posting)
                            @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                        @endif
                    </div>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="updateStatus('current', false)">
                    <div class="flex items-center justify-between w-full">
                        <span>Current (no posting)</span>
                        @if (Str::contains($story->status, 'Current') && ! $story->allow_posting)
                            @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                        @endif
                    </div>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="updateStatus('completed')">
                    <div class="flex items-center justify-between w-full">
                        <span>Completed</span>
                        @if (Str::contains($story->status, 'Completed'))
                            @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                        @endif
                    </div>
                </x-dropdown.item>
            </x-dropdown.group>
        </x-dropdown>
    @endcan

    @cannot('update', $story)
        <x-badge :color="$story->status->color()" size="xs">
            @if ($story->canPost)
                <x-slot name="leadingIcon">
                    @icon('edit', $component->iconStyles())
                </x-slot>
            @endif

            {{ $story->status->displayName() }}
        </x-badge>
    @endcannot
</div>