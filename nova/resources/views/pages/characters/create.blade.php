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

            <x-form.section title="Ownership">
                <x-slot name="message">
                    @can('create', new Nova\Characters\Models\Character)
                        <p>Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.</p>
                    @endcan

                    @cannot('create', new Nova\Characters\Models\Character)
                        <p>Set whether this character should be automatically linked to your account.</p>

                        @if (app('nova.settings')->characters->requireApprovalForCharacterCreation)
                            <p><span class="font-semibold">Note:</span> This character will not be available until an admin has reviewed and approved it.</p>
                        @endif

                        {{-- <p><span class="font-semibold">Note:</span> You have reached the maximum allowed number of linked characters. If this character is intended to be linked to your account it will be created, but will require approval for it to be available on your account.</p> --}}
                    @endcan


                </x-slot>

                <x-input.group label="Assign User(s)">
                    @livewire('users:collector', ['users' => old('users')])
                </x-input.group>

                {{-- <x-input.group>
                    <x-input.toggle field="active" :value="old('active', 'true')">
                        Link this character to my account
                    </x-input.toggle>
                </x-input.group> --}}
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add Character</x-button>
                <x-link :href="route('characters.index', 'status=active')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
