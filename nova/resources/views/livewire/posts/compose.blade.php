<div
    x-data="{ sidebarOpen: false }"
    x-on:keydown.window.escape="sidebarOpen = false"
    class="h-screen flex overflow-hidden bg-gray-100"
>
    <!-- Off-canvas menu for mobile -->
    <div x-show="sidebarOpen" class="md:hidden" x-cloak>
        <div class="fixed inset-0 flex z-40">
            <div
                x-on:click="sidebarOpen = false"
                x-show="sidebarOpen"
                x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0"
            >
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>

            <div
                x-show="sidebarOpen"
                x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white"
            >
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button
                        x-show="sidebarOpen"
                        x-on:click="sidebarOpen = false"
                        class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
                        aria-label="Close sidebar"
                    >
                        @icon('close', 'h-6 w-6 text-white')
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>

                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="px-2">
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium text-gray-900 rounded-md bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                            @icon('dashboard', 'mr-4 h-6 w-6 text-gray-500 group-hover:text-gray-500 group-focus:text-gray-600 transition ease-in-out duration-150')
                            Dashboard
                        </a>
                        <a href="{{ route('notes.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('note', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            My Notes
                        </a>
                        {{-- <a href="{{ route('notes.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('users', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            Players
                        </a> --}}

                        @can('create', 'Nova\Posts\Models\Post')
                            <a href="{{ route('posts.create') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                                @icon('write', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                                Write New Post
                            </a>
                        @endcan

                        <div class="mt-1 group flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('book', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            Stories
                        </div>
                        <div class="flex flex-col ml-12">
                            @can('viewAny', 'Nova\Stories\Models\Story')
                                <a href="{{ route('stories.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Stories</a>
                            @endcan

                            @can('viewAny', 'Nova\PostTypes\Models\PostType')
                                <a href="{{ route('post-types.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Post Types</a>
                            @endcan
                        </div>

                        @if (auth()->user()->canManage())
                            <div class="mt-1 group flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                                @icon('settings', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                                Manage
                            </div>
                            <div class="flex flex-col ml-12">
                                @can('viewAny', 'Nova\Characters\Models\Character')
                                    <a href="{{ route('departments.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Characters</a>
                                @endcan

                                @can('viewAny', 'Nova\Departments\Models\Department')
                                    <a href="{{ route('departments.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Departments</a>
                                @endcan

                                @can('viewAny', 'Nova\Ranks\Models\RankItem')
                                    <a href="{{ route('ranks.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Ranks</a>
                                @endcan

                                @can('viewAny', 'Nova\Roles\Models\Role')
                                    <a href="{{ route('roles.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Roles</a>
                                @endcan

                                @can('viewAny', 'Nova\Settings\Models\Settings')
                                    <a href="{{ route('settings.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Settings</a>
                                @endcan

                                @can('viewAny', 'Nova\Themes\Models\Theme')
                                    <a href="{{ route('themes.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Themes</a>
                                @endcan

                                @can('viewAny', 'Nova\Users\Models\User')
                                    <a href="{{ route('users.index', 'status=active') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Users</a>
                                @endcan
                            </div>
                        @endif
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden | md:flex md:flex-shrink-0">
        <div class="flex flex-col justify-between w-64 border-r border-gray-200 pt-5 pb-4 bg-white">
            <div>
                <div class="flex items-center flex-shrink-0 px-4">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>

                <div class="mt-5 flex-1 flex flex-col overflow-y-auto">
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <nav class="flex-1 px-4 bg-white space-y-8">
                        <x-button-link :href="route('posts.create')" color="dark-gray-text" size="none">
                            @icon('chevron-left')
                            Pick a different post type
                        </x-button-link>

                        <div class="flex flex-col">
                            <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Your characters</span>
                            Select your characters
                        </div>

                        @if ($postType->options->multipleAuthors)
                            <div class="flex flex-col">
                                <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other characters</span>
                                Add more characters
                            </div>

                            <div class="flex flex-col">
                                <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other contributors</span>
                                Add other contributors
                            </div>
                        @endif
                    </nav>
                </div>
            </div>

            <div class="flex items-center space-x-4 px-4">
                <x-button wire:click="publish" color="blue" full-width>Publish</x-button>

                <x-button wire:click="save" wire:poll.30s="save" color="white" :disabled="$saving" full-width>
                    @if ($saving)
                        Saving...
                    @else
                        Save
                    @endif
                </x-button>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow | md:hidden">
            <button
                x-on:click.stop="sidebarOpen = true"
                class="px-4 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 | md:hidden"
                aria-label="Open sidebar"
            >
                @icon('menu', 'h-6 w-6')
            </button>

            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex">
                    <div class="w-full flex | md:ml-0">
                        <label for="search_field" class="sr-only">Search</label>
                        <div class="flex items-center relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="flex-shrink-0 mr-2 pointer-events-none leading-0">
                                @icon('search', 'h-6 w-6')
                            </div>

                            <input
                                id="search_field"
                                class="block w-full h-full pr-3 py-2 text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400"
                                placeholder="Search"
                                type="search"
                            >
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex items-center | md:ml-6">
                    @livewire('users:notifications')

                    <x-dropdown placement="bottom-end" class="ml-4">
                        <x-slot name="trigger">
                            <x-avatar size="xs" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                        </x-slot>

                        <button class="{{ $component->link() }}" form="logout-form" role="menuitem">
                            @icon('sign-out', $component->icon())
                            <span>Sign out</span>
                        </button>

                        <x-form :action="route('logout')" class="hidden" id="logout-form" />
                    </x-dropdown>
                </div>
            </div>
        </div>

        <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
            <div class="max-w-6xl mx-auto px-4 | sm:px-6 md:px-8">
                <div class="w-full mb-8">
                    @if ($allStories->count() === 1)
                        <p class="text-base font-semibold text-gray-500 mb-2">{{ $allStories->first()->title }}</p>
                    @endif

                    @if ($allStories->count() > 1)
                        <x-dropdown class="text-base font-semibold text-gray-500 mb-2" wide>
                            <x-slot name="trigger">
                                <div class="inline-flex items-center space-x-1">
                                    <span>{{ $story->title }}</span>
                                    <svg class="h-4 w-4 -mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-slot>

                            @foreach ($allStories as $selectStory)
                                <button wire:click="setStory({{ $selectStory->id }})" class="{{ $component->link() }}">{{ $selectStory->title }}</button>
                            @endforeach
                        </x-dropdown>
                    @endif

                    <x-posts.field
                        :field="$postType->fields->title"
                        name="title"
                        :suggestion="$suggestion"
                        :value="$title"
                        wire:model.lazy="title"
                        placeholder="Add your title"
                        class="text-3xl font-extrabold text-gray-900 tracking-tight | sm:text-4xl md:text-5xl"
                        tabindex="1"
                    ></x-posts.field>

                    @if ($postType->fields->time->enabled || $postType->fields->day->enabled || $postType->fields->location->enabled)
                        <div class="flex flex-col space-y-8 text-gray-600 text-lg font-medium mt-8 | md:mt-4 md:flex-row md:items-start md:space-x-8 md:space-y-0">
                            <x-posts.field
                                :field="$postType->fields->day"
                                icon="calendar"
                                name="day"
                                :suggestion="$suggestion"
                                :value="$day"
                                wire:model.lazy="day"
                                placeholder="Add a day"
                                tabindex="2"
                            ></x-posts.field>

                            <x-posts.field
                                :field="$postType->fields->time"
                                icon="clock"
                                name="time"
                                :suggestion="$suggestion"
                                :value="$time"
                                wire:model.lazy="time"
                                placeholder="Add a time"
                                tabindex="3"
                            ></x-posts.field>

                            <x-posts.field
                                :field="$postType->fields->location"
                                icon="location"
                                name="location"
                                :suggestion="$suggestion"
                                :value="$location"
                                wire:model.lazy="location"
                                placeholder="Add a location"
                                tabindex="4"
                            ></x-posts.field>
                        </div>
                    @endif
                </div>

                {{-- <x-input.group for="content" label="Content" :error="$errors->first('content')">
                    <x-input.rich-text wire:model.debounce="content" name="content" :initial-value="old('content')" tabindex="5" />
                </x-input.group> --}}

                {{-- <x-posts.editor
                    :field="$postType->fields->content"
                    name="content"
                    :suggestion="$suggestion"
                    :value="$content"
                    wire:model.debounce="content"
                    tabindex="6"
                ></x-posts.editor> --}}

                <div wire:ignore>
                    <posts-editor></posts-editor>
                </div>
            </div>
        </main>
    </div>
</div>