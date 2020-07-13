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
                    <button wire:click="removeCharacter({{ $loop->index }})" type="button" class="ml-3 group inline-flex items-center text-gray-600 transition ease-in-out duration-150 hover:text-gray-500 focus:outline-none">
                        @icon('delete', 'h-6 w-6 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
                    </button>
                @endif

                <button wire:click="addCharacter({{ $loop->index }})" type="button" class="ml-1 group inline-flex items-center text-gray-600 transition ease-in-out duration-150 hover:text-gray-500 focus:outline-none">
                    @icon('add-alt', 'h-6 w-6 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
                </button>
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
