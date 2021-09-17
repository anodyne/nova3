@extends($meta->template)

@section('content')
    <x-page-header title="Add Character">
        <x-slot name="pretitle">
            <a href="{{ route('characters.index', 'status=active') }}">Characters</a>
        </x-slot>
    </x-page-header>

    <x-panel on-edge>
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

            @can('create', Nova\Characters\Models\Character::class)
                <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.">

                    <x-input.group label="Assign User(s)">
                        @livewire('users:collector', ['users' => old('users')])
                    </x-input.group>
                </x-form.section>
            @else
                <div class="px-4 py-4 md:px-8 md:py-8">
                    <h3 class="font-bold text-xl text-gray-12 tracking-tight mb-4">Ownership</h3>

                    <div class="w-full">
                        <div class="rounded-md bg-purple-3 border border-purple-6 p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @icon('alert', 'h-6 w-6 text-purple-9')
                                </div>
                                <div class="ml-3 flex-1 text-purple-11 space-y-4">
                                    @if (settings()->characters->requireApprovalForCharacterCreation)
                                        <p><span class="font-semibold">Note:</span> This character will not be available until an admin has reviewed and approved it.</p>
                                    @endif

                                    @if (settings()->characters->enforceCharacterLimits && auth()->user()->activeCharacters()->count() >= settings()->characters->characterLimit)
                                        <p><span class="font-semibold">Note:</span> You have reached the maximum allowed number of linked characters. If this character is intended to be linked to your account it will be created, but will require approval for it to be available on your account.</p>
                                    @endif

                                    <p><span class="font-semibold">Note:</span> You have reached the maximum allowed number of linked characters. If this character is intended to be linked to your account it will be created, but will require approval for it to be available on your account.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <x-form.section title="Ownership" class="border-purple-3">
                    <x-slot name="message">
                        <p>Set whether this character should be automatically linked to your account.</p>

                        @if (settings()->characters->requireApprovalForCharacterCreation)
                            <p><span class="font-semibold">Note:</span> This character will not be available until an admin has reviewed and approved it.</p>
                        @endif

                        @if (settings()->characters->enforceCharacterLimits && auth()->user()->activeCharacters()->count() >= settings()->characters->characterLimit)
                            <p><span class="font-semibold">Note:</span> You have reached the maximum allowed number of linked characters. If this character is intended to be linked to your account it will be created, but will require approval for it to be available on your account.</p>
                        @endif
                    </x-slot>

                    <x-input.group>
                        <x-input.toggle field="self_assign" :value="old('self_assign', 'true')">
                            Link this character to my account
                        </x-input.toggle>
                    </x-input.group>
                </x-form.section> --}}
            @endcan

            <x-form.footer>
                <x-button type="submit" color="blue">Add Character</x-button>
                <x-link :href="route('characters.index', 'status=active')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
