@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$character->name">
            <x-slot:actions>
                <x-button.text :href="route('characters.index')" leading="arrow-left" color="gray">
                    Back
                </x-button.text>

                @can('update', $character)
                    <x-button.filled :href="route('characters.edit', $character)" leading="edit" color="primary">Edit</x-button.filled>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form action="">
            <x-form.section title="Character Info">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $character->name }}</p>
                </x-input.group>

                @if ($character->rank)
                    <x-input.group label="Rank">
                        <div class="flex items-center">
                            <x-rank :rank="$character->rank" />
                            <span class="ml-3 font-medium">{{ $character->rank?->name?->name }}</span>
                        </div>
                    </x-input.group>
                @endif

                @if ($character->positions->count() > 0)
                    <x-input.group>
                        <x-slot:label>
                            @choice('Position|Positions', $character->positions)
                        </x-slot:label>

                        <div class="flex flex-col w-full">
                            @foreach ($character->positions as $position)
                                <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                                    {{ $position->name }}
                                </div>
                            @endforeach
                        </div>
                    </x-input.group>
                @endif

                <x-input.group label="Status">
                    <x-badge :color="$character->status->color()">{{ $character->status->displayName() }}</x-badge>
                </x-input.group>

                <x-input.group label="Character Type">
                    <x-badge :color="$character->type->color()">{{ $character->type->displayName() }}</x-badge>
                </x-input.group>

                <x-input.group label="Avatar">
                    <x-avatar :src="$character->avatar_url" size="lg" />
                </x-input.group>
            </x-form.section>

            @if ($character->users->count() > 0)
                <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.">
                    <x-input.group label="Played By">
                        <div class="flex flex-col w-full">
                            @foreach ($character->users as $user)
                                <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-50">
                                    <div class="flex items-center">
                                        <x-avatar.user :user="$user" :secondary-status="true"></x-avatar.user>
                                    </div>

                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}" class="text-gray-600 transition ease-in-out duration-200 hover:text-gray-900 group-hover:visible sm:invisible">
                                            <x-icon name="edit" size="sm"></x-icon>
                                        </a>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    </x-input.group>
                </x-form.section>
            @endif
        </x-form>
    </x-panel>
@endsection
