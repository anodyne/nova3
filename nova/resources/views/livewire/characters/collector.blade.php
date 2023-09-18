<div>
    <input type="hidden" name="characters" value="{{ $characterIds }}" />

    @foreach ($characters as $character)
        <div class="@if (! $loop->first) mt-4 @endif flex flex-col">
            <div class="flex w-full items-center">
                <livewire:characters:dropdown
                    :index="$loop->index"
                    :character="$character['id']"
                    :wire:key="Str::random()"
                />

                @if (count($characters) > 1)
                    <x-button.text
                        wire:click="removeCharacter({{ $loop->index }})"
                        type="button"
                        color="neutral-danger"
                        class="ml-3"
                    >
                        <x-icon name="trash" size="md"></x-icon>
                    </x-button.text>
                @endif

                <x-button.text wire:click="addCharacter({{ $loop->index }})" type="button" color="gray" class="ml-1">
                    <x-icon name="add" size="md"></x-icon>
                </x-button.text>
            </div>

            @if ($character['id'] !== null)
                <div class="ml-px mt-2 text-sm">
                    <x-input.radio
                        label="Primary character"
                        name="primary_character"
                        id="primary_character_{{ $character['id'] }}"
                        for="primary_character_{{ $character['id'] }}"
                        value="{{ $character['id'] }}"
                        :checked="$character['primary']"
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
