@extends($meta->template)

@use('Nova\Departments\Models\Position')
@use('Nova\Users\Models\User')

@section('content')
    <x-spacing x-data="tabsList('info')" constrained>
        <x-page-header>
            <x-slot name="heading">{{ $user->name }}</x-slot>
            <x-slot name="description">
                <x-badge :color="$user->status->color()" size="md">
                    {{ $user->status->getLabel() }}
                </x-badge>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', User::class)
                    <x-button :href="route('admin.users.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $user)
                    <x-button :href="route('admin.users.edit', $user)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-tab.group name="user" class="mb-12">
            <x-tab.heading name="info">
                <x-icon name="info" size="sm"></x-icon>
                Basic info
            </x-tab.heading>
            <x-tab.heading name="stats">
                <x-icon name="chart" size="sm"></x-icon>
                Stats
            </x-tab.heading>

            @if (filled($form->published_fields))
                <x-tab.heading name="bio">
                    <x-icon name="user-profile" size="sm"></x-icon>
                    Bio
                </x-tab.heading>
            @endif
        </x-tab.group>

        <div class="space-y-12" x-show="isTab('stats')">
            <x-panel well>
                <x-panel.well.header title="Characters"></x-panel.well.header>

                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    <x-spacing size="sm" class="grid lg:grid-cols-2">
                        <x-panel.stat label="Active characters" :value="$user->active_characters_count"></x-panel.stat>
                        <x-panel.stat label="Total characters" :value="$user->characters_count"></x-panel.stat>
                    </x-spacing>

                    <x-spacing size="md" class="grid gap-4">
                        @forelse ($user->characters as $character)
                            <x-avatar.character :character="$character"></x-avatar.character>
                        @empty
                            <div class="lg:col-span-2">
                                <x-empty-state>
                                    <x-icon name="characters"></x-icon>
                                    <x-h3>No characters assigned</x-h3>
                                    <x-text>
                                        There aren’t any positions assigned to this department. Assign some positions to
                                        this department to populate this list.
                                    </x-text>

                                    @can('viewAny', Position::class)
                                        <x-button :href="route('admin.positions.index')" plain>
                                            Assign positions
                                        </x-button>
                                    @endcan
                                </x-empty-state>
                            </div>
                        @endforelse
                    </x-spacing>
                </x-panel>
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
                                    <x-empty-state>
                                        <x-icon name="books"></x-icon>
                                        <x-h3>No published posts</x-h3>
                                        <x-text>There aren’t any published posts by this user</x-text>
                                    </x-empty-state>
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

        <div class="w-full max-w-md" x-show="isTab('bio')">
            <livewire:dynamic-form
                :form="$form"
                :submission="$user->userFormSubmission"
                :owner="$user"
                :admin="true"
                :static="true"
            />
        </div>
    </x-spacing>
@endsection
