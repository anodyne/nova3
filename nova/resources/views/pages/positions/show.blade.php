@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$position->name">
            <x-slot:actions>
                @can('viewAny', Nova\Departments\Models\Position::class)
                    <x-button.text :href="route('positions.index', 'department='.$position->department->id)" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>

                    @can('update', $position)
                        <x-button.filled :href="route('positions.edit', $position)" leading="edit" color="primary">Edit</x-button.filled>
                    @endcan
                @endcan
            </x-slot:actions>
        </x-panel.header>

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
                                <x-avatar.character
                                    :character="$character"
                                    :primary-status="true"
                                    :primary-rank="false"
                                    :secondary-positions="false"
                                    :secondary-type="true"
                                ></x-avatar.character>
                            </div>

                            @can('update', $character)
                                <x-button.text :href="route('characters.edit', $character)" color="gray" class="group-hover:visible sm:invisible">
                                    <x-icon name="edit" size="sm"></x-icon>
                                </x-button.text>
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
        </x-form>
    </x-panel>
@endsection
