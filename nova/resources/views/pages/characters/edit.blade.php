@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$character->name">
        <x-slot name="pretitle">
            <a href="{{ route('characters.index', "status={$character->status->name()}") }}">Characters</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('characters.update', $character)" method="PUT">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $character->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Position(s)" :error="$errors->first('positions')">
                    @livewire(
                        'positions:collector',
                        ['positions' => old('positions', $character->positions->implode('id', ','))]
                    )
                </x-input.group>

                <x-input.group label="Rank">
                    @livewire('ranks:items-dropdown', ['rank' => old('rank_id', $character->rank_id)])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar" message="Character avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('characters:upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all users will have the same permissions with the character. Additionally, if the character takes any action that sends a notification, all users will be notified.">
                <x-input.group label="User(s)">
                    @livewire(
                        'users:collector',
                        ['users' => old('users', $character->users->implode('id', ','))]
                    )
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Character</button>

                <a href="{{ route('characters.index', "status={$character->status->name()}") }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
