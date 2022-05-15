@extends($meta->template)

@php($settings = settings())

@section('content')
    <x-page-header title="Add Character">
        <x-slot:pretitle>
            <a href="{{ route('characters.index', 'status=active') }}">Characters</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('characters.store')">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Position(s)" :error="$errors->first('positions')">
                    @livewire('positions:collector', [
                        'positions' => old('positions'),
                        'primaryPosition' => old('primaryPosition'),
                    ])
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

            @can('create', Nova\Characters\Models\Character::class)
                <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.">

                    <x-input.group label="Assign User(s)">
                        @livewire('users:collector', [
                            'users' => old('users'),
                            'primaryCharacters' => old('primaryCharacters'),
                        ])
                    </x-input.group>
                </x-form.section>
            @else
                <x-form.section title="Ownership" class="border-purple-3">
                    <x-slot:message>
                        @if (! $settings->characters->autoLinkCharacter)
                            <p>Set whether this character should be automatically linked to your account.</p>
                        @endif

                        @if ($settings->characters->requireApprovalForCharacterCreation)
                            <p><span class="font-semibold">Note:</span> This character will not be available until an admin has reviewed and approved it.</p>
                        @endif

                        @if ($settings->characters->enforceCharacterLimits && auth()->user()->activeCharacters()->count() >= $settings->characters->characterLimit)
                            <p><span class="font-semibold">Note:</span> You have reached the maximum allowed number of linked characters. If this character is intended to be linked to your account it will be created, but will require approval for it to be available on your account.</p>
                        @endif
                    </x-slot:message>

                    @if ($settings->characters->autoLinkCharacter)
                        <x-alert class="bg-gray-50 border-gray-300 text-gray-600">This character will automatically be linked to your account.</x-alert>

                        <input type="hidden" name="self_assign" value="true">

                        @if ($settings->characters->allowSettingPrimaryCharacter)
                            <x-input.group>
                                <x-input.toggle field="self_primary_assign" :value="old('self_primary_assign', false)">
                                    Make this character my primary character
                                </x-input.toggle>
                            </x-input.group>
                        @else
                            <x-alert class="bg-gray-50 border-gray-300 text-gray-600">You will need contact the Game Master if you would like this character to be marked as your primary character.</x-alert>

                            <input type="hidden" name="self_primary_assign" value="true">
                        @endif
                    @else
                        <x-input.group>
                            <x-input.toggle field="self_assign" :value="old('self_assign', 'true')">
                                Link this character to my account
                            </x-input.toggle>
                        </x-input.group>
                    @endif
                </x-form.section>
            @endcan

            <x-form.footer>
                <x-button type="submit" color="blue">Add Character</x-button>
                <x-link :href="route('characters.index', 'status=active')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
