@extends($meta->template)

@use('Nova\Users\Models\User')

@section('content')
    <x-spacing x-data="tabsList('stats')" constrained>
        <x-page-header>
            <x-slot name="heading">{{ $user->name }}</x-slot>
            <x-slot name="description">
                <x-badge :color="$user->status->color()" size="md">
                    {{ $user->status->getLabel() }}
                </x-badge>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', User::class)
                    <x-button :href="route('users.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $user)
                    <x-button :href="route('users.edit', $user)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-tab.group name="user" class="mb-6">
            <x-tab.heading name="details">Details</x-tab.heading>
            <x-tab.heading name="stats">Stats</x-tab.heading>
        </x-tab.group>

        <div class="space-y-8">
            <x-panel well>
                <x-spacing size="xs">
                    <x-fieldset.legend>Characters</x-fieldset.legend>
                </x-spacing>

                <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        <x-spacing size="sm" class="grid lg:grid-cols-2">
                            <x-panel.stat
                                label="Active characters"
                                :value="$user->active_characters_count"
                            ></x-panel.stat>
                            <x-panel.stat label="Total characters" :value="$user->characters_count"></x-panel.stat>
                        </x-spacing>

                        <x-spacing size="md" class="grid gap-4">
                            @forelse ($user->characters as $character)
                                <x-avatar.character :character="$character"></x-avatar.character>
                            @empty
                                <div class="lg:col-span-2">
                                    <x-empty-state.small
                                        icon="characters"
                                        title="No characters assigned"
                                        message="There aren’t any positions assigned to this department. Assign some positions to this department to populate this list."
                                        :link-access="gate()->allows('viewAny', Nova\Departments\Models\Position::class)"
                                        :link="route('positions.index')"
                                        label="Assign positions"
                                    ></x-empty-state.small>
                                </div>
                            @endforelse
                        </x-spacing>
                    </x-panel>
                </x-spacing>
            </x-panel>

            <x-panel well>
                <x-spacing size="xs">
                    <x-fieldset.legend>Posting</x-fieldset.legend>
                </x-spacing>

                <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        <x-spacing size="sm" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Published posts" :value="$user->published_posts_count"></x-panel.stat>
                            <x-panel.stat label="Last posted">
                                {{ $user->latestPost->first()?->published_at?->diffForHumans() ?? '-' }}
                            </x-panel.stat>
                        </x-spacing>

                        <x-spacing size="md" class="grid gap-4 lg:grid-cols-2">
                            @forelse ($publishedPosts as $post)
                                {{ $post->title }}
                            @empty
                                <div class="lg:col-span-2">
                                    <x-empty-state.small
                                        icon="books"
                                        title="No published posts"
                                        message="There aren’t any published posts by this user"
                                    ></x-empty-state.small>
                                </div>
                            @endforelse
                        </x-spacing>
                    </x-panel>
                </x-spacing>
            </x-panel>

            <x-panel class="lg:col-span-3" well>
                <x-spacing size="xs">
                    <x-fieldset.legend>History / activity</x-fieldset.legend>
                </x-spacing>

                <x-spacing size="2xs">
                    <x-panel>
                        <x-spacing size="sm" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Joined">
                                {{ $user->created_at->diffForHumans() }}
                            </x-panel.stat>
                            <x-panel.stat label="Last signed in">
                                {{ $user->latestLogin?->created_at->diffForHumans() ?? '-' }}
                            </x-panel.stat>
                        </x-spacing>
                    </x-panel>
                </x-spacing>
            </x-panel>
        </div>
    </x-spacing>
@endsection
