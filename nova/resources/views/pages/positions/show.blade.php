@extends($meta->template)

@section('content')
    <x-page-header :title="$position->name">
        <x-slot:pretitle>
            <div class="flex items-center">
                <a href="{{ route('positions.index') }}">Positions</a>
                <x-icon.chevron-right class="h-4 w-4 text-gray-500 mx-1" />
                <a href="{{ route('positions.index', "department={$position->department->id}") }}">{{ $position->department->name }}</a>
            </div>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $position)
                <x-link :href="route('positions.edit', $position)" color="blue">Edit Position</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Position Info">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $position->name }}</p>
                </x-input.group>

                @if ($position->description)
                    <x-input.group label="Description">
                        <p class="font-semibold">{{ $position->description }}</p>
                    </x-input.group>
                @endif

                <x-input.group label="Department">
                    <p class="font-semibold">{{ $position->department->name }}</p>
                </x-input.group>

                <x-input.group label="Available Slots">
                    <p class="font-semibold">{{ $position->available }}</p>
                </x-input.group>

                <x-input.group label="Status">
                    <x-badge :color="$position->status->color()">{{ $position->status->displayName() }}</x-badge>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Characters">
                <div class="flex flex-col w-full space-y-2">
                    @forelse ($position->characters as $character)
                        <div class="group flex items-center justify-between w-full py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                            <div class="flex items-center space-x-3">
                                <x-avatar-meta size="lg" :src="$character->avatar_url">
                                    <x-slot:primaryMeta>
                                        <x-status :status="$character->status" />
                                        <span class="ml-2">{{ $character->name }}</span>
                                    </x-slot:primaryMeta>

                                    <x-slot:secondaryMeta>
                                        <x-badge :color="$character->type->color()" size="xs">{{ $character->type->displayName() }}</x-badge>
                                    </x-slot:secondaryMeta>
                                </x-avatar-meta>
                            </div>

                            @can('update', $character)
                                <x-link :href="route('characters.edit', $character)" color="gray-text" size="none" class="group-hover:visible sm:invisible">
                                    @icon('edit')
                                </x-link>
                            @endcan
                        </div>
                    @empty
                        <x-empty-state.small
                            icon="users"
                            title="No assigned characters"
                            :link="route('characters.index')"
                            label="Assign characters"
                            :link-access="gate()->allows('update', new Nova\Characters\Models\Character())"
                        ></x-empty-state.small>
                    @endforelse
                </div>
            </x-form.section>

            <x-form.footer>
                <x-link :href="route('positions.index', $position->department)" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
