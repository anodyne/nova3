<div>
    <x-dropdown>
        <x-slot name="trigger">
            <x-button icon:trailing="chevron-down">
                <div class="flex items-center gap-2">
                    @if ($selectedRank)
                        <x-rank :rank="$selectedRank" />
                    @endif

                    <x-heading>{{ $selectedRank->name?->name ?? 'Choose a rank' }}</x-heading>
                </div>
            </x-button>
        </x-slot>

        @foreach ($rankGroups as $group)
            <flux:menu.submenu :heading="$group->name">
                <flux:menu.radio.group wire:model.live="selected">
                    @foreach ($group->ranks as $rank)
                        <flux:menu.radio :value="$rank->id">
                            <div class="flex items-center gap-2">
                                <x-rank :$rank />
                                <span>{{ $rank->name?->name }}</span>
                            </div>
                        </flux:menu.radio>
                    @endforeach
                </flux:menu.radio.group>
            </flux:menu.submenu>
        @endforeach
    </x-dropdown>

    <input type="hidden" name="rank_id" value="{{ $selected }}" />
</div>
