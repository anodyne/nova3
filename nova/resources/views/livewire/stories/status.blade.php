<div class="leading-0">
    @can('update', $story)
        <x-dropdown placement="bottom-end md:bottom-start" wide>
            <x-slot:trigger>
                <x-badge :color="$story->status->color()" size="xs">
                    {{ $story->status->displayName() }}

                    <x-slot:trailingIcon>
                        <svg class="{{ $component->iconStyles() }} -mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </x-slot:trailingIcon>
                </x-badge>
            </x-slot:trigger>

            <x-dropdown.group>
                <x-dropdown.item type="button" wire:click="updateStatus('upcoming')">
                    <div class="flex w-full">
                        <div class="flex-1 text-left">
                            <span>Upcoming</span>
                            <div class="text-sm text-gray-9 text-left font-normal mt-1">
                                Story or story arc that will happen in the future
                            </div>
                        </div>
                        <div class="flex justify-end shrink-0 w-8">
                            @if ($story->status->equals('upcoming'))
                                @icon('check', 'h-6 w-6 text-blue-9')
                            @endif
                        </div>
                    </div>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="updateStatus('ongoing')">
                    <div class="flex w-full">
                        <div class="flex-1 text-left">
                            <span>Ongoing</span>
                            <div class="text-sm text-gray-9 text-left font-normal mt-1">
                                Active story or story arc that cannot be posted into
                            </div>
                        </div>
                        <div class="flex justify-end shrink-0 w-8">
                            @if ($story->status->equals('ongoing'))
                                @icon('check', 'h-6 w-6 text-blue-9')
                            @endif
                        </div>
                    </div>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="updateStatus('current')">
                    <div class="flex w-full">
                        <div class="flex-1 text-left">
                            <span>Current</span>
                            <div class="text-sm text-gray-9 text-left font-normal mt-1">
                                Story that is current running and players can post into
                            </div>
                        </div>
                        <div class="flex justify-end shrink-0 w-8">
                            @if ($story->status->equals('current'))
                                @icon('check', 'h-6 w-6 text-blue-9')
                            @endif
                        </div>
                    </div>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="updateStatus('completed')">
                    <div class="flex w-full">
                        <div class="flex-1 text-left">
                            <span>Completed</span>
                            <div class="text-sm text-gray-9 text-left font-normal mt-1">
                                Story or story arc that has concluded
                            </div>
                        </div>
                        <div class="flex justify-end shrink-0 w-8">
                            @if ($story->status->equals('completed'))
                                @icon('check', 'h-6 w-6 text-blue-9')
                            @endif
                        </div>
                    </div>
                </x-dropdown.item>
            </x-dropdown.group>
        </x-dropdown>
    @endcan

    @cannot('update', $story)
        <x-badge :color="$story->status->color()" size="xs">
            @if ($story->canPost)
                <x-slot:leadingIcon>
                    @icon('edit', $component->iconStyles())
                </x-slot:leadingIcon>
            @endif

            {{ $story->status->displayName() }}
        </x-badge>
    @endcannot
</div>