@extends($meta->template)

@use('Nova\Users\Models\User')

@section('content')
    <x-container.narrow>
        <x-page-header>
            <x-slot name="heading">{{ $user->name }}</x-slot>
            <x-slot name="description">
                <div class="mt-2">
                    <x-badge :color="$user->status->color()" size="md">
                        {{ $user->status->getLabel() }}
                    </x-badge>
                </div>
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

        <ul data-slot="tabs" class="mb-6 flex items-center gap-x-4">
            <li
                @class([
                    'rounded-full px-4 py-0.5 text-sm/6 font-semibold ',
                    'text-gray-500 dark:text-gray-400' => true,
                    'bg-gray-950/10 text-gray-900 dark:bg-white/10 dark:text-white' => false,
                ])
            >
                Details
            </li>
            <li
                @class([
                    'rounded-full px-4 py-0.5 text-sm/6 font-semibold ',
                    'text-gray-500 dark:text-gray-400' => false,
                    'bg-gray-950/10 text-gray-900 dark:bg-white/10 dark:text-white' => true,
                ])
            >
                Stats
            </li>
        </ul>

        <div class="space-y-8">
            <x-panel well>
                <x-container height="xs" width="xs">
                    <x-fieldset.legend>Characters</x-fieldset.legend>
                </x-container>

                <x-container height="2xs" width="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        <x-container height="sm" width="sm" class="grid lg:grid-cols-2">
                            <x-panel.stat
                                label="Active characters"
                                :value="$user->active_characters_count"
                            ></x-panel.stat>
                            <x-panel.stat label="Total characters" :value="$user->characters_count"></x-panel.stat>
                        </x-container>

                        <x-container class="grid gap-4 lg:grid-cols-2">
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
                        </x-container>
                    </x-panel>
                </x-container>
            </x-panel>

            <x-panel well>
                <x-container height="xs" width="xs">
                    <x-fieldset.legend>Posting</x-fieldset.legend>
                </x-container>

                <x-container height="2xs" width="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        <x-container height="sm" width="sm" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Published posts" :value="$user->published_posts_count"></x-panel.stat>
                            <x-panel.stat label="Last posted">
                                {{ $user->latestPost->first()?->published_at?->diffForHumans() ?? '-' }}
                            </x-panel.stat>
                        </x-container>

                        <x-container class="grid gap-4 lg:grid-cols-2">
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
                        </x-container>
                    </x-panel>
                </x-container>
            </x-panel>

            <x-panel class="lg:col-span-3" well>
                <x-container height="xs" width="xs">
                    <x-fieldset.legend>History / activity</x-fieldset.legend>
                </x-container>

                <x-container height="2xs" width="2xs">
                    <x-panel>
                        <x-container height="sm" width="sm" class="grid lg:grid-cols-2">
                            <x-panel.stat label="Joined">
                                {{ $user->created_at->diffForHumans() }}
                            </x-panel.stat>
                            <x-panel.stat label="Last signed in">
                                {{ $user->latestLogin?->created_at->diffForHumans() ?? '-' }}
                            </x-panel.stat>
                        </x-container>
                    </x-panel>
                </x-container>
            </x-panel>
        </div>
    </x-container.narrow>
@endsection
