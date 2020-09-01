@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$position->name">
        <x-slot name="pretitle">
            <div class="flex items-center">
                <a href="{{ route('departments.index') }}">Departments</a>
                @icon('chevron-right', 'h-4 w-4 text-gray-500 mx-1')
                <a href="{{ route('positions.index', $position->department) }}">{{ $position->department->name }}</a>
            </div>
        </x-slot>

        <x-slot name="controls">
            @can('update', $position)
                <x-button-link :href="route('positions.edit', $position)" color="blue">Edit Position</x-button-link>
            @endcan
        </x-slot>
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
                    @if ($position->active)
                        <x-badge type="success">Active</x-badge>
                    @else
                        <x-badge>Inactive</x-badge>
                    @endif
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Characters">
                <div class="flex flex-col w-full space-y-2">
                    @foreach ($position->characters as $character)
                        <div class="group flex items-center justify-between w-full py-2 px-4 rounded odd:bg-gray-100">
                            <div class="flex items-center space-x-3">
                                <x-avatar-meta size="lg" :src="$character->avatar_url">
                                    <x-slot name="primaryMeta">
                                        <x-status :status="$character->status" />
                                        <span class="ml-2">{{ $character->name }}</span>
                                    </x-slot>

                                    <x-slot name="secondaryMeta">
                                        <x-badge :type="$character->type->color()" size="sm">{{ $character->type->displayName() }}</x-badge>
                                    </x-slot>
                                </x-avatar-meta>
                            </div>

                            @can('update', $character)
                                <a href="{{ route('characters.edit', $character) }}" class="text-gray-500 transition ease-in-out duration-150 hover:text-gray-700 group-hover:visible | sm:invisible">
                                    @icon('edit')
                                </a>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button-link :href="route('positions.index', $position->department)" color="white">Back</x-button-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
