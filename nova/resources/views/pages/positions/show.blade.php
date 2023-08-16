@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden">
        <x-panel.header :message="$position->department?->name">
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $position->name }}</span>
                    <div class="flex items-center">
                        <x-badge :color="$position->status->color()">{{ $position->status->getLabel() }}</x-badge>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', Nova\Departments\Models\Position::class)
                    <x-button.text
                        :href="route('positions.index', 'department='.$position->department->id)"
                        leading="arrow-left"
                        color="gray"
                    >
                        Back
                    </x-button.text>

                    @can('update', $position)
                        <x-button.filled :href="route('positions.edit', $position)" leading="edit" color="primary">
                            Edit
                        </x-button.filled>
                    @endcan
                @endcan
            </x-slot>
        </x-panel.header>

        <div class="flex flex-col divide-gray-200 lg:flex-row lg:divide-x">
            <div class="flex flex-1 flex-col justify-between gap-6 divide-y divide-gray-200">
                @if (filled($position->description))
                    <x-content-box>
                        <p class="max-w-xl text-lg">{{ $position->description }}</p>
                    </x-content-box>
                @endif

                <x-content-box>
                    <div class="grid grid-cols-1 gap-px bg-white/5 lg:grid-cols-3">
                        <div class="px-4 sm:px-6">
                            <p class="text-sm font-medium leading-6">Assigned characters</p>
                            <p class="mt-2 flex items-baseline gap-x-2">
                                <span class="text-4xl font-semibold tracking-tight text-gray-900">
                                    {{ $position->active_characters_count }}
                                </span>
                            </p>
                        </div>
                        <div class="px-4 sm:px-6">
                            <p class="text-sm font-medium leading-6">Playing users</p>
                            <p class="mt-2 flex items-baseline gap-x-2">
                                <span class="text-4xl font-semibold tracking-tight text-gray-900">
                                    {{ $position->active_users_count }}
                                </span>
                            </p>
                        </div>
                        <div class="px-4 sm:px-6">
                            <p class="text-sm font-medium leading-6">Available slots</p>
                            <p class="mt-2 flex items-baseline gap-x-2">
                                <span class="text-4xl font-semibold tracking-tight text-gray-900">
                                    {{ $position->available }}
                                </span>
                            </p>
                        </div>
                    </div>
                </x-content-box>
            </div>

            <div class="w-full divide-y divide-gray-200 lg:w-1/3">
                <div class="flex w-full flex-col">
                    <div class="px-4 py-4">
                        <x-h3>Characters</x-h3>
                    </div>

                    <div>
                        @forelse ($position->activeCharacters as $character)
                            <div
                                class="group flex w-full items-center justify-between px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                            >
                                <div class="flex items-center space-x-3">
                                    <x-avatar.character
                                        :character="$character"
                                        :primary-rank="false"
                                        :secondary-positions="false"
                                        :secondary-type="true"
                                    ></x-avatar.character>
                                </div>

                                @can('update', $character)
                                    <x-button.text
                                        :href="route('characters.edit', $character)"
                                        color="gray"
                                        class="group-hover:visible sm:invisible"
                                    >
                                        <x-icon name="edit" size="sm"></x-icon>
                                    </x-button.text>
                                @endcan
                            </div>
                        @empty
                            <x-content-box class="flex flex-col gap-2 text-center">
                                <x-icon
                                    name="characters"
                                    size="h-12 w-12"
                                    class="mx-auto text-gray-400 dark:text-gray-500"
                                ></x-icon>
                                <x-h4>No assigned characters</x-h4>
                            </x-content-box>
                        @endforelse
                    </div>
                </div>

                <div class="flex w-full flex-col">
                    <div class="px-4 py-4">
                        <x-h3>Users</x-h3>
                    </div>

                    <div>
                        @forelse ($position->activeUsers as $user)
                            <div
                                class="group flex w-full items-center justify-between px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                            >
                                <div class="flex items-center space-x-3">
                                    <x-avatar.user :user="$user"></x-avatar.user>
                                </div>
                            </div>
                        @empty
                            <x-content-box class="flex flex-col gap-2 text-center">
                                <x-icon
                                    name="users"
                                    size="h-12 w-12"
                                    class="mx-auto text-gray-400 dark:text-gray-500"
                                ></x-icon>
                                <x-h4>No assigned users</x-h4>
                            </x-content-box>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-panel>
@endsection
