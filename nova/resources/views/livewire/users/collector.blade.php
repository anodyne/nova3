<div>
    @foreach ($users as $user)
        <input type="hidden" name="users[]" value="{{ $user['id'] }}">

        <div class="flex flex-col @if (! $loop->first) mt-4 @endif">
            <div class="flex items-center w-full space-x-2">
                <livewire:users:dropdown
                    :index="$loop->index"
                    :user="$user['id']"
                    :wire:key="Str::random()"
                />

                @if (count($users) > 1)
                    <x-button.text tag="button" color="gray-danger" wire:click="removeUser({{ $loop->index }})">
                        <x-icon name="trash" size="md"></x-icon>
                    </x-button.text>
                @endif

                <x-button.text color="gray" tag="button" wire:click="addUser({{ $loop->index }})">
                    <x-icon name="add" size="md"></x-icon>
                </x-button.text>
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
