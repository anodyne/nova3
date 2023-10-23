@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden">
        <x-panel.header>
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $user->name }}</span>
                    <div class="flex items-center">
                        <x-badge :color="$user->status->color()">
                            {{ $user->status->getLabel() }}
                        </x-badge>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', Nova\Users\Models\User::class)
                    <x-button.text :href="route('users.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan

                @can('update', $user)
                    <x-button.filled :href="route('users.edit', $user)" leading="edit" color="primary">
                        Edit
                    </x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <div class="flex flex-col divide-gray-200 lg:flex-row lg:divide-x">
            <div class="flex flex-1 flex-col gap-6 divide-y divide-gray-200">
                <x-content-box>
                    <div class="grid grid-cols-1 gap-y-8 lg:grid-cols-3">
                        <x-panel.stat label="Active characters" :value="$user->active_characters_count"></x-panel.stat>
                        <x-panel.stat label="Total characters" :value="$user->characters_count"></x-panel.stat>
                        <x-panel.stat
                            label="Total published posts"
                            :value="$user->published_posts_count"
                        ></x-panel.stat>
                        <x-panel.stat label="Joined">
                            {{ $user->created_at->diffForHumans() }}
                        </x-panel.stat>
                        <x-panel.stat label="Last signed in">
                            {{ $user->latestLogin?->created_at->diffForHumans() ?? '-' }}
                        </x-panel.stat>
                        <x-panel.stat label="Last posted">
                            {{ $user->latestPost->first()?->published_at?->diffForHumans() }}
                        </x-panel.stat>
                    </div>
                </x-content-box>

                <x-content-box class="flex flex-col gap-4">Dynamic form content will go here.</x-content-box>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="flex w-full flex-col">
                    <div class="flex items-center justify-between px-4 py-4">
                        <x-h3>Characters</x-h3>
                    </div>

                    <div>
                        @forelse ($user->characters as $character)
                            <div
                                class="group flex items-center justify-between px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                            >
                                <div class="flex items-center gap-3">
                                    <x-status :status="$character->status"></x-status>
                                    <span>{{ $character->display_name }}</span>
                                </div>
                                @can('update', $character)
                                    <x-button.text
                                        :href="route('characters.edit', $character)"
                                        color="gray"
                                        class="shrink-0 group-hover:visible sm:invisible"
                                    >
                                        <x-icon name="edit" size="sm"></x-icon>
                                    </x-button.text>
                                @endcan
                            </div>
                        @empty
                            <div class="px-4">
                                <x-empty-state.small
                                    icon="list"
                                    title="No positions assigned"
                                    message="There aren’t any positions assigned to this department. Assign some positions to this department to populate this list."
                                    :link-access="gate()->allows('viewAny', Nova\Departments\Models\Position::class)"
                                    :link="route('positions.index')"
                                    label="Assign positions"
                                ></x-empty-state.small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-panel>

    <div class="grid hidden grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
        <div class="space-y-8 lg:col-span-2">
            <x-panel>
                <x-content-box>
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between lg:space-x-8">
                        <div>
                            <x-avatar.user :user="$user" size="xl" :secondary-pronouns="true"></x-avatar.user>
                        </div>

                        <div class="flex items-center space-x-4">
                            <x-badge :color="$user->status->color()">
                                {{ $user->status->getLabel() }}
                            </x-badge>
                        </div>
                    </div>

                    <div class="mt-4 space-x-4">
                        @can('update', $user)
                            <x-button.filled :href="route('users.edit', $user)" leading="edit" color="primary">
                                Edit
                            </x-button.filled>
                        @endcan

                        <x-button.text :href="route('users.index')" leading="arrow-left" color="gray">
                            Back
                        </x-button.text>
                    </div>
                </x-content-box>
            </x-panel>

            <x-panel>
                <x-content-box>Dynamic form content will go here</x-content-box>
            </x-panel>
        </div>

        <div>
            <x-panel class="divide-y divide-gray-200 dark:divide-gray-600/50">
                @if ($user->characters->count() > 0)
                    <x-content-box>
                        <div class="flex w-full flex-col space-y-4">
                            @foreach ($user->characters as $character)
                                <div class="flex items-center justify-between">
                                    <x-avatar.character :character="$character"></x-avatar.character>

                                    @if ($character->pivot->primary)
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
