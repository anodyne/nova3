<div>
    @foreach ($users as $user)
        <input type="hidden" name="users[]" value="{{ $user['id'] }}">

        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full">
                @livewire(
                    'users:dropdown',
                    ['index' => $loop->index, 'user' => $user['id']],
                    key(Str::random())
                )

                @if (count($users) > 1)
                    <button wire:click="removeUser({{ $loop->index }})" type="button" class="ml-3 inline-flex items-center text-gray-9 transition ease-in-out duration-200 hover:text-red-9 focus:outline-none">
                        @icon('delete', 'h-6 w-6')
                    </button>
                @endif

                <button wire:click="addUser({{ $loop->index }})" type="button" class="ml-1 inline-flex items-center text-gray-9 transition ease-in-out duration-200 hover:text-gray-11 focus:outline-none">
                    @icon('add', 'h-6 w-6')
                </button>
            </div>

            @if ($user['id'] !== null)
                <div class="mt-2 ml-px text-sm">
                    <x-input.checkbox
                        label="Primary character"
                        name="primaryCharacters[]"
                        id="primaryCharacters{{ $user['id'] }}"
                        for="primaryCharacters{{ $user['id'] }}"
                        value="{{ $user['id'] }}"
                        :checked="$user['primary']"
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
