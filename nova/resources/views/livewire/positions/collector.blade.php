<div>
    @foreach ($positions as $position)
        <input type="hidden" name="positions[]" value="{{ $position['id'] }}" />

        <div class="@if (! $loop->first) mt-4 @endif flex flex-col">
            <div class="flex w-full items-center space-x-2" wire:model="positions">
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
        </div>
    @endforeach
</div>
