<div>
    <input type="hidden" name="characters" value="{{ $characterIds }}">

    @foreach ($characters as $character)
        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full">
                @livewire(
                    'characters:dropdown',
                    ['index' => $loop->index, 'character' => $character['id']],
                    key(Str::random())
                )

                @if (count($characters) > 1)
                    <x-button wire:click="removeCharacter({{ $loop->index }})" type="button" color="gray-text" size="none" class="ml-3">
                        @icon('delete', 'h-6 w-6')
                    </x-button>
                @endif

                <x-button wire:click="addCharacter({{ $loop->index }})" type="button" color="gray-text" size="none" class="ml-1">
                    @icon('add-alt', 'h-6 w-6')
                </x-button>
            </div>

            @if ($character['id'] !== null)
                <div class="mt-2 ml-px text-sm">
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
