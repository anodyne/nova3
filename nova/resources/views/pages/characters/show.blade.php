@extends($meta->template)

@section('content')
    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
        <div class="space-y-8 lg:col-span-2">
            <x-panel>
                <x-content-box>
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between lg:space-x-8">
                        <div>
                            <x-avatar.character :character="$character" size="xl" :secondary-positions="false">
                                @if ($character->rank)
                                    <x-slot name="secondary">
                                        <x-rank :rank="$character->rank" />
                                    </x-slot>
                                @endif
                            </x-avatar.character>
                        </div>

                        <div class="flex items-center space-x-4">
                            <x-badge :color="$character->status->color()">
                                {{ $character->status->getLabel() }}
                            </x-badge>

                            <x-badge :color="$character->type->color()">
                                {{ $character->type->getLabel() }}
                            </x-badge>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center space-x-4">
                        @can('update', $character)
                            <x-button :href="route('characters.edit', $character)" color="primary">
                                <x-icon name="edit" size="sm"></x-icon>
                                Edit
                            </x-button>
                        @endcan

                        <x-button :href="route('characters.index')" plain>&larr; Back</x-button>
                    </div>
                </x-content-box>
            </x-panel>

            <x-panel>
                <x-content-box>Dynamic form content will go here</x-content-box>
            </x-panel>
        </div>

        <div>
            <x-panel class="divide-y divide-gray-200 dark:divide-gray-600/50">
                @if ($character->positions->count() > 0)
                    <x-content-box>
                        <div class="text-sm font-medium text-gray-500">
                            Assigned
                            @choice('position|positions', $character->positions)
                        </div>
                        <div class="mt-2 flex w-full flex-col space-y-1.5">
                            @foreach ($character->positions as $position)
                                <div class="group flex items-center font-medium text-gray-600 dark:text-gray-400">
                                    {{ $position->name }}
                                </div>
                            @endforeach
                        </div>
                    </x-content-box>
                @endif

                @if ($character->users->count() > 0)
                    <x-content-box>
                        <div class="flex w-full flex-col space-y-4">
                            @foreach ($character->users as $user)
                                <div class="flex items-center justify-between">
                                    <x-avatar.user :user="$user" :secondary-status="true"></x-avatar.user>

                                    @if ($user->pivot->primary)
                                        <x-badge color="primary">Primary</x-badge>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-content-box>
                @endif
            </x-panel>
        </div>
    </div>
@endsection
