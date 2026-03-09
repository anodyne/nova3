@use('Nova\Characters\Models\Character')
@use('Nova\Departments\Models\Position')
@use('Nova\Users\Models\User')

<x-admin-layout>
    <x-spacing x-data="tabsList('info')" constrained>
        <x-page-heading :heading="$user->name">
            <x-slot name="description">
                <x-metadata.group size="md" gap="lg">
                    <x-metadata label="Status">
                        <x-badge :color="$user->status->getColor()" size="md">
                            {{ $user->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </x-metadata.group>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', User::class)
                    <x-button :href="route('admin.users.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $user)
                    <x-button :href="route('admin.users.edit', $user)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-tab.group class="mb-12">
            <x-slot name="tabs">
                <x-tab name="info">
                    <x-icon :name="Tabler::InfoCircle" size="sm" />
                    Basic info
                </x-tab>
                <x-tab name="stats">
                    <x-icon :name="Tabler::ChartBar" size="sm" />
                    Stats
                </x-tab>

                @if (filled($form->published_fields))
                    <x-tab name="bio">
                        <x-icon :name="Tabler::UserCircle" size="sm" />
                        Bio
                    </x-tab>
                @endif
            </x-slot>

            <x-tab.panel name="info" class="space-y-12">
                <x-fieldset>
                    <x-fieldset.group constrained>
                        <x-input.display label="Email address">
                            <x-text>{{ $user->email }}</x-text>
                        </x-input.display>

                        <x-input.display label="Pronouns">
                            <x-text>{{ $user->pronouns }}</x-text>
                        </x-input.display>
                    </x-fieldset.group>
                </x-fieldset>
            </x-tab.panel>

            <x-tab.panel name="stats" class="space-y-12">
                <x-panel variant="well">
                    <x-panel.header title="Characters"></x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        <x-spacing size="md" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Active characters" :value="$user->active_characters_count" />
                            <x-panel.stat label="Total characters" :value="$user->characters_count" />
                        </x-spacing>

                        <x-spacing size="md" class="grid grid-cols-2 gap-4">
                            @forelse ($user->characters as $character)
                                <x-avatar.character :$character positions />
                            @empty
                                <div class="lg:col-span-2">
                                    <x-empty>
                                        <x-illustration :name="Illustration::Vulcan" />
                                        <x-empty.heading>No characters assigned</x-empty.heading>
                                        <x-empty.text>
                                            There aren’t any characters assigned to this user. Assign some characters to
                                            this user to populate this list.
                                        </x-empty.text>

                                        @can('viewAny', Character::class)
                                            <x-button :href="route('admin.characters.index')" variant="ghost">
                                                Assign characters
                                                <span aria-hidden="true">→</span>
                                            </x-button>
                                        @endcan
                                    </x-empty>
                                </div>
                            @endforelse
                        </x-spacing>
                    </x-panel>
                </x-panel>

                <x-panel variant="well">
                    <x-panel.header title="Posting"></x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        <x-spacing size="md" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Published posts" :value="$user->published_posts_count"></x-panel.stat>
                            <x-panel.stat label="Last posted">
                                {!! $user->latestPost->first()?->published_at?->diffForHumans() ?? '&ndash;' !!}
                            </x-panel.stat>
                        </x-spacing>

                        <x-spacing size="md" class="grid gap-4 lg:grid-cols-2">
                            @forelse ($publishedPosts as $post)
                                {{ $post->title }}
                            @empty
                                <div class="lg:col-span-2">
                                    <x-empty>
                                        <x-illustration :name="Tabler::Book" />
                                        <x-empty.heading>No published posts</x-empty.heading>
                                        <x-empty.text>There aren’t any published posts by this user</x-empty.text>
                                    </x-empty>
                                </div>
                            @endforelse
                        </x-spacing>
                    </x-panel>
                </x-panel>

                <x-panel class="lg:col-span-3" variant="well">
                    <x-panel.header title="History / activity"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Joined">
                                {{ $user->created_at->diffForHumans() }}
                            </x-panel.stat>
                            <x-panel.stat label="Last signed in">
                                {!! $user->latestLogin?->created_at->diffForHumans() ?? '&ndash;' !!}
                            </x-panel.stat>
                        </x-spacing>
                    </x-panel>
                </x-panel>
            </x-tab.panel>

            <x-tab.panel name="bio" class="w-full max-w-md">
                <livewire:dynamic-form
                    :form="$form"
                    :submission="$user->userFormSubmission"
                    :owner="$user"
                    :admin="true"
                    :static="true"
                />
            </x-tab.panel>
        </x-tab.group>
    </x-spacing>
</x-admin-layout>
