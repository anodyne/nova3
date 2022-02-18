@extends($meta->template)

@section('content')
    <x-page-header :title="$character->name">
        <x-slot:pretitle>
            <a href="{{ route('characters.index', "status={$character->status->name()}") }}">Characters</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('characters.update', $character)" method="PUT">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $character->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Position(s)" :error="$errors->first('positions')">
                    @livewire('positions:collector', [
                        'positions' => old('positions', $character->positions->pluck('id')->all()),
                        'primaryPosition' => old('primaryPosition', $character->primaryPosition->first()?->id),
                        'character' => $character,
                    ])
                </x-input.group>

                <x-input.group label="Rank">
                    @livewire('ranks:items-dropdown', ['rank' => old('rank_id', $character->rank_id)])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar" message="Character avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('upload-avatar', ['existingAvatar' => $character->avatar_url])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.">
                <x-input.group label="Assign User(s)">
                    @livewire('users:collector', [
                        'users' => old('users', $character->users->pluck('id')),
                        'primaryCharacters' => old('primaryCharacters', $character->primaryUsers->pluck('id')->all()),
                        'character' => $character,
                    ])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Update Character</x-button>
                <x-link :href='route("characters.index", "status={$character->status->name()}")'>Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>

    @can('deactivate', $character)
        <x-panel class="mt-8">
            <x-content-box>
                <h3 class="text-lg font-medium text-gray-12">
                    Deactivate Character
                </h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full text-gray-11">
                        <p>
                            When deactivating the character, the owning user(s) will remain at their current status. Pay special attention to deactivating a character who is the only character assigned to a user as it may impede their ability to contribute to stories.
                        </p>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-8 sm:shrink-0 sm:flex sm:items-center">
                        <x-form :action="route('characters.deactivate', $character)">
                            <x-button type="submit" color="red-outline">
                                Deactivate
                            </x-button>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan

    @can('activate', $character)
        <x-panel class="mt-8">
            <x-content-box>
                <h3 class="text-lg font-medium text-gray-12">
                    Activate Character
                </h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full text-gray-11">
                        <p>
                            When activating the character, if they were previously a primary character for the user, but the user has since had a new primary character set for themselves, this character will be set as a secondary character for the user.
                        </p>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-8 sm:shrink-0 sm:flex sm:items-center">
                        <x-form :action="route('characters.activate', $character)">
                            <x-button type="submit" color="blue-outline">
                                Activate
                            </x-button>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan
@endsection
