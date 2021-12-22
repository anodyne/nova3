<div>
    @foreach ($positions as $position)
        <input type="hidden" name="positions[]" value="{{ $position['id'] }}">

        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full" wire:model="positions">
                @livewire(
                    'positions:dropdown',
                    ['index' => $loop->index, 'position' => $position['id']],
                    key(Str::random())
                )

                @if (count($positions) > 1)
                    <x-button wire:click="removePosition({{ $loop->index }})" type="button" color="gray-text" size="none" class="ml-3">
                        @icon('delete', 'h-6 w-6')
                    </x-button>
                @endif

                <x-button wire:click="addPosition({{ $loop->index }})" type="button" color="gray-text" size="none" class="ml-1">
                    @icon('add', 'h-6 w-6')
                </x-button>
            </div>

            @if (count($positions) > 1)
                <div class="mt-2 ml-px text-sm">
                    <x-input.radio
                        label="Primary position"
                        name="primaryPosition"
                        id="primaryPosition{{ $position['id'] }}"
                        for="primaryPosition{{ $position['id'] }}"
                        value="{{ $position['id'] }}"
                        :checked="$position['primary']"
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
