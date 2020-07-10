@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$character->name">
        <x-slot name="pretitle">
            <a href="{{ route('characters.index', "status={$character->status->name()}") }}">Characters</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $character)
                <a href="{{ route('characters.edit', $character) }}" class="button button-primary">Edit Character</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
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
                            <div class="group flex items-center justify-between py-2 px-4 rounded even:bg-gray-100">
                                {{ $position->name }}
                            </div>
                        @endforeach
                    </div>
                </x-input.group>
            @endif

            <x-input.group label="Status">
                <x-badge :type="$character->status->color()">{{ $character->status->displayName() }}</x-badge>
            </x-input.group>

            <x-input.group label="Character Type">
                <x-badge :type="$character->type->color()">{{ $character->type->displayName() }}</x-badge>
            </x-input.group>

            <x-input.group label="Avatar">
                <x-avatar :url="$character->avatar_url" size="lg"></x-avatar>
            </x-input.group>
        </x-form.section>

        @if ($character->users->count() > 0)
            <x-form.section title="Ownership" message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character.">
                <x-input.group label="Played By">
                    <div class="flex flex-col w-full">
                        @foreach ($character->users as $user)
                            <div class="group flex items-center py-2 px-4 rounded even:bg-gray-100">
                                <div class="flex-shrink-0">
                                    <x-avatar size="lg" :url="$user->avatar_url" />
                                </div>
                                <span class="ml-3 font-medium">{{ $user->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </x-input.group>
            </x-form.section>
        @endif

        <x-form.footer>
            <a href="{{ route('characters.index', "status={$character->status->name()}") }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
