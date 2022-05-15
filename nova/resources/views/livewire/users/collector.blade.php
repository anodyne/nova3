<div>
    @foreach ($users as $user)
        <input type="hidden" name="users[]" value="{{ $user['id'] }}">

        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full space-x-2">
                @livewire(
                    'users:dropdown',
                    ['index' => $loop->index, 'user' => $user['id']],
                    key(Str::random())
                )

                @if (count($users) > 1)
                    <x-button wire:click="removeUser({{ $loop->index }})" type="button" color="gray-red-text" size="none">
                        @icon('delete', 'h-6 w-6')
                    </x-button>
                @endif

                <x-button wire:click="addUser({{ $loop->index }})" type="button" color="gray-text" size="none">
                    @icon('add', 'h-6 w-6')
                </x-button>
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
