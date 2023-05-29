<div>
    @foreach ($positions as $position)
        <input type="hidden" name="positions[]" value="{{ $position['id'] }}">

        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full space-x-2" wire:model="positions">
                <livewire:positions:dropdown
                    :index="$loop->index"
                    :position="$position['id']"
                    :wire:key="Str::random()"
                />

                @if (count($positions) > 1)
                    <x-button.text tag="button" color="gray-danger" wire:click="removePosition({{ $loop->index }})">
                        <x-icon name="trash" size="md"></x-icon>
                    </x-button.text>
                @endif

                <x-button.text color="gray" tag="button" wire:click="addPosition({{ $loop->index }})">
                    <x-icon name="add" size="md"></x-icon>
                </x-button.text>
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
