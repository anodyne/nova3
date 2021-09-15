<div>
    <input type="hidden" name="users" value="{{ $userIds }}">

    @foreach ($users as $user)
        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full">
                @livewire(
                    'users:dropdown',
                    ['index' => $loop->index, 'user' => $user['id']],
                    key(Str::random())
                )

                @if (count($users) > 1)
                    <button wire:click="removeUser({{ $loop->index }})" type="button" class="ml-3 inline-flex items-center text-gray-9 transition ease-in-out duration-150 hover:text-red-9 focus:outline-none">
                        @icon('delete', 'h-6 w-6')
                    </button>
                @endif

                <button wire:click="addUser({{ $loop->index }})" type="button" class="ml-1 inline-flex items-center text-gray-9 transition ease-in-out duration-150 hover:text-gray-11 focus:outline-none">
                    @icon('add-alt', 'h-6 w-6')
                </button>
            </div>

            @if ($user['id'] !== null)
                <div class="mt-2 ml-px text-sm">
                    <x-input.checkbox
                        label="Primary character"
                        name="primary_character[]"
                        id="primary_character_{{ $user['id'] }}"
                        for="primary_character_{{ $user['id'] }}"
                        value="{{ $user['id'] }}"
                        :checked="$user['primary']"
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
