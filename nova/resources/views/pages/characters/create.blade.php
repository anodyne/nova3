@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Character">
        <x-slot name="pretitle">
            <a href="{{ route('characters.index', 'status=active') }}">Characters</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('characters.store')">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Position(s)" :error="$errors->first('positions')">
                    @livewire('positions:collector', ['positions' => old('positions')])
                </x-input.group>

                <x-input.group label="Rank">
                    @livewire('ranks:items-dropdown', ['rank' => old('rank_id')])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar" message="Character avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.">
                <x-input.group label="Assign User(s)">
                    @livewire('users:collector', ['users' => old('users')])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Character</button>

                <a href="{{ route('characters.index', 'status=active') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
