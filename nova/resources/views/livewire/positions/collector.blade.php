<div>
    <input type="hidden" name="positions" value="{{ $positionIds }}">

    @foreach ($positions as $position)
        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full" wire:model="positions">
                @livewire(
                    'positions:dropdown',
                    ['index' => $loop->index, 'position' => $position['id']],
                    key(Str::random())
                )

                <button wire:click="addPosition({{ $loop->index }})" type="button" class="ml-3 group inline-flex items-center text-gray-600 transition ease-in-out duration-150 hover:text-gray-500 focus:outline-none">
                    @icon('add-alt', 'h-6 w-6 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
                </button>

                @if (count($positions) > 1)
                    <button wire:click="removePosition({{ $loop->index }})" type="button" class="ml-1 group inline-flex items-center text-gray-600 transition ease-in-out duration-150 hover:text-gray-500 focus:outline-none">
                        @icon('delete', 'h-6 w-6 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
                    </button>
                @endif
            </div>

            @if (count($positions) > 1)
                <div class="mt-2 ml-px text-sm">
                    <x-input.radio label="Primary position" name="primary_position" id="primary_position_{{ $position['id'] }}" for="primary_position_{{ $position['id'] }}" value="{{ $position['id'] }}" />
                </div>
            @endif
        </div>
    @endforeach
</div>
