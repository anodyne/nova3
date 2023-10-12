<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="users" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                Manage post authors
            </h3>
        </div>
    </x-content-box>

    <div class="h-96 max-h-96 space-y-6 overflow-auto">
        <x-content-box height="none" class="mt-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Characters</h3>
                <x-button.filled
                    color="primary"
                    wire:click="$dispatch('openModal', 'posts:select-character-authors-modal')"
                >
                    Add characters
                </x-button.filled>
            </div>
        </x-content-box>

        <x-content-box width="none" height="none">
            <x-table-list columns="5">
                <x-slot:header>
                    <div class="col-span-3">Name</div>
                    <div class="col-span-2">Played by</div>
                </x-slot>

                @foreach ($selectedCharactersDisplay as $key => $character)
                    <x-table-list.row>
                        <div class="col-span-3 flex items-center">
                            <x-avatar.meta
                                :src="$character['character']['avatar_url']"
                                size="sm"
                                :primary="$character['character']['name']"
                            ></x-avatar.meta>
                        </div>

                        <div
                            @class([
                                'col-span-2 flex items-center',
                            ])
                        >
                            @if ($character['user'] !== null)
                                {{ $character['user'] }}
                            @else
                                <x-input.select wire:model="selectedCharacters.{{ $key }}.user_id">
                                    @foreach ($character['character']['active_users'] as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </x-input.select>
                            @endif
                        </div>

                        <x-slot:actions>
                            <x-icon name="trash" size="md"></x-icon>
                        </x-slot>
                    </x-table-list.row>
                @endforeach

                {{-- <x-table-list.row> --}}
                {{-- <div class="flex items-center col-span-3"> --}}
                {{-- <x-avatar.meta --}}
                {{-- src="https://www.startrek.com/sites/default/files/styles/content_full/public/images/2019-07/89abe98de6071178edb1b28901a8f459.jpg?itok=UEwq0IRl" --}}
                {{-- primary="Captain James Kirk" --}}
                {{-- size="sm" --}}
                {{-- ></x-avatar.meta> --}}
                {{-- </div> --}}
                {{-- <div @class([ --}}
                {{-- 'flex items-center col-span-2', --}}
                {{-- ])> --}}
                {{-- <x-input.select> --}}
                {{-- <option value="1">William Shatner</option> --}}
                {{-- <option value="1">Chris Pine</option> --}}
                {{-- </x-input.select> --}}
                {{-- </div> --}}

                {{-- <x-slot:actions> --}}
                {{-- <x-icon name="trash" size="md"></x-icon> --}}
                {{-- </x-slot:actions> --}}
                {{-- </x-table-list.row> --}}
                {{-- <x-table-list.row> --}}
                {{-- <div class="flex items-center col-span-3"> --}}
                {{-- <x-avatar.meta --}}
                {{-- src="https://m.media-amazon.com/images/M/MV5BOWUzNWNiOGItNmZhYi00Y2NmLTg0YjktYTNiMjY3ZDVkMjgzXkEyXkFqcGdeQXVyMjQ3MjU3NTU@._V1_.jpg" --}}
                {{-- primary="Ensign Ro Laren" --}}
                {{-- size="sm" --}}
                {{-- ></x-avatar.meta> --}}
                {{-- </div> --}}
                {{-- <div @class([ --}}
                {{-- 'flex items-center col-span-2', --}}
                {{-- ])> --}}
                {{-- <x-input.select> --}}
                {{-- <option value="1">Not played by a user</option> --}}
                {{-- <option value="1">William Shatner</option> --}}
                {{-- <option value="1">Chris Pine</option> --}}
                {{-- </x-input.select> --}}
                {{-- </div> --}}

                {{-- <x-slot:actions> --}}
                {{-- <x-icon name="trash" size="md"></x-icon> --}}
                {{-- </x-slot:actions> --}}
                {{-- </x-table-list.row> --}}
                {{-- <x-table-list.row> --}}
                {{-- <div class="flex items-center col-span-3"> --}}
                {{-- <x-avatar.meta --}}
                {{-- src="https://www.startrek.com/sites/default/files/styles/content_full/public/images/2019-07/a01a0380ca3c61428c26a231f0e49a09.jpg?itok=KuKoT68w" --}}
                {{-- primary="Ensign Nog" --}}
                {{-- size="sm" --}}
                {{-- ></x-avatar.meta> --}}
                {{-- </div> --}}
                {{-- <div @class([ --}}
                {{-- 'flex items-center col-span-2', --}}
                {{-- ])> --}}
                {{-- <x-input.select> --}}
                {{-- <option value="1">Not played by a user</option> --}}
                {{-- <option value="1" selected>Aron Eisenberg</option> --}}
                {{-- </x-input.select> --}}
                {{-- </div> --}}

                {{-- <x-slot:actions> --}}
                {{-- <x-icon name="trash" size="md"></x-icon> --}}
                {{-- </x-slot:actions> --}}
                {{-- </x-table-list.row> --}}
            </x-table-list>
        </x-content-box>

        <x-content-box height="none" class="mt-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Users</h3>
                <x-button.filled color="primary">Add users</x-button.filled>
            </div>
        </x-content-box>

        <x-content-box width="none" height="none">
            <x-table-list columns="5">
                <x-slot:header>
                    <div class="col-span-3">Name</div>
                    <div class="col-span-2">Playing as</div>
                </x-slot>

                <x-table-list.row>
                    <div class="col-span-3 flex items-center">
                        <x-avatar.meta
                            src="https://fanfilmfactor.com/wp-content/uploads/2017/04/JG-Hertzler.jpg"
                            primary="J.G. Hertzler"
                            size="sm"
                        ></x-avatar.meta>
                    </div>
                    <div @class([
                        'col-span-2 flex items-center',
                    ])>
                        <x-input.text placeholder="Who is this user playing?"></x-input.text>
                    </div>

                    <x-slot:actions>
                        <x-icon name="trash" size="md"></x-icon>
                    </x-slot>
                </x-table-list.row>
                <x-table-list.row>
                    <div class="col-span-3 flex items-center">
                        <x-avatar.meta
                            src="https://m.media-amazon.com/images/M/MV5BMjE3Njg1NDEzN15BMl5BanBnXkFtZTcwNTk4Nzg5MQ@@._V1_.jpg"
                            primary="Jeffrey Combs"
                            size="sm"
                        ></x-avatar.meta>
                    </div>
                    <div @class([
                        'col-span-2 flex items-center',
                    ])>
                        <x-input.text value="Weyoun"></x-input.text>
                    </div>

                    <x-slot:actions>
                        <x-icon name="trash" size="md"></x-icon>
                    </x-slot>
                </x-table-list.row>
            </x-table-list>
        </x-content-box>
    </div>

    <x-content-box
        class="z-20 rounded-b-lg bg-gray-50 dark:bg-gray-700/50 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse"
        height="sm"
        width="sm"
    >
        <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>
        <x-button.filled color="neutral" wire:click="dismiss">Cancel</x-button.filled>
    </x-content-box>
</div>
