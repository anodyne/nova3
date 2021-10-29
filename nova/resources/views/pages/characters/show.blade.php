@extends($meta->template)

@section('content')
    <x-page-header :title="$character->name">
        <x-slot name="pretitle">
            <a href="{{ route('characters.index', "status={$character->status->name()}") }}">Characters</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $character)
                <x-link :href="route('characters.edit', $character)" color="blue">Edit Character</x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Character Info">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $character->name }}</p>
                </x-input.group>

                @if ($character->rank)
                    <x-input.group label="Rank">
                        <div class="flex items-center">
                            <x-rank :rank="$character->rank" />
                            <span class="ml-3 font-medium">{{ optional(optional($character->rank)->name)->name }}</span>
                        </div>
                    </x-input.group>
                @endif

                @if ($character->positions->count() > 0)
                    <x-input.group>
                        <x-slot name="label">
                            @choice('Position|Positions', $character->positions)
                        </x-slot>

                        <div class="flex flex-col w-full">
                            @foreach ($character->positions as $position)
                                <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100">
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
                                <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-3">
                                    <div class="flex items-center">
                                        <x-avatar-meta size="lg" :src="$user->avatar_url">
                                            <x-slot name="primaryMeta">
                                                {{ $user->name }}
                                            </x-slot>

                                            <x-slot name="secondaryMeta">
                                                <x-badge :color="$user->status->color()" size="xs">{{ $user->status->displayName() }}</x-badge>
                                            </x-slot>
                                        </x-avatar-meta>
                                    </div>

                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}" class="text-gray-11 transition ease-in-out duration-200 hover:text-gray-12 group-hover:visible sm:invisible">
                                            @icon('edit')
                                        </a>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    </x-input.group>
                </x-form.section>
            @endif

            <x-form.footer>
                <x-link :href='route("characters.index", "status={$character->status->name()}")' color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
