@php
    use Nova\Applications\Models\Application;
    use Nova\Pages\Models\Page;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)" />
        {!! SEO::generate() !!}

        {{ NovaView::renderHook('admin::styles.before') }}

        <x-fonts section="admin" />
        @filamentStyles
        @novaAdminStyles
        @stack('styles')

        {{ NovaView::renderHook('admin::styles.after') }}
        {{ NovaView::renderHook('admin::head-scripts.before') }}

        @stack('headScripts')

        {{ NovaView::renderHook('admin::head-scripts.after') }}
    </head>
    <body
        class="h-full bg-white font-[family-name:--font-body] text-gray-600 antialiased dark:bg-gray-950 dark:text-gray-400 xl:bg-gray-100 dark:xl:bg-gray-950"
        @if (settings('appearance.panda')) data-panda @endif
    >
        {{ NovaView::renderHook('admin::body.start') }}

        <div id="nova">
            {{ NovaView::renderHook('admin::page.start') }}

            <div
                class="relative flex min-h-svh w-full bg-white dark:bg-gray-900 max-lg:flex-col lg:bg-gray-100 dark:lg:bg-gray-950"
                x-data="{ open: false }"
            >
                {{-- Sidebar on desktop --}}
                <div class="fixed inset-y-0 left-0 w-64 max-lg:hidden">
                    <x-sidebar>
                        <x-sidebar.header>
                            <x-sidebar.section>
                                <div class="mb-2 flex px-2">
                                    <a href="{{ route('admin.dashboard') }}" aria-label="Home">
                                        @if (app('nova.settings')->getFirstMedia('logo'))
                                            <img
                                                src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                                                alt="logo"
                                                class="block h-8 w-auto"
                                            />
                                        @else
                                            <x-logos.nova class="hidden h-8 w-auto md:block" />
                                            <x-logos.nova-mark class="block h-8 w-auto md:hidden" />
                                        @endif
                                    </a>
                                </div>
                            </x-sidebar.section>

                            <x-sidebar.section>
                                <x-sidebar.item href="#">
                                    <x-icon name="search"></x-icon>
                                    <x-sidebar.label>Search</x-sidebar.label>
                                </x-sidebar.item>

                                <x-sidebar.item
                                    :href="route('admin.messages.index')"
                                    :active="request()->routeIs('admin.messages.*')"
                                >
                                    <x-icon name="inbox"></x-icon>
                                    <x-sidebar.label>Messages</x-sidebar.label>

                                    @if ($unreadMessagesCount() > 0)
                                        <x-slot name="trailing">
                                            <x-badge color="primary" class="tabular-nums">
                                                {{ $unreadMessagesCount() }}
                                            </x-badge>
                                        </x-slot>
                                    @endif
                                </x-sidebar.item>

                                <livewire:users-notifications />

                                <x-sidebar.item
                                    :href="route('admin.announcements.index')"
                                    :active="request()->routeIs('admin.announcements.*')"
                                >
                                    <x-icon name="megaphone"></x-icon>
                                    <x-sidebar.label>Announcements</x-sidebar.label>

                                    @if ($unreadAnnouncementsCount() > 0)
                                        <x-slot name="trailing">
                                            <x-badge color="primary" class="tabular-nums">
                                                {{ $unreadAnnouncementsCount() }}
                                            </x-badge>
                                        </x-slot>
                                    @endif
                                </x-sidebar.item>
                            </x-sidebar.section>
                        </x-sidebar.header>

                        <x-sidebar.body>
                            <x-sidebar.section>
                                <x-sidebar.item
                                    :href="route('admin.dashboard')"
                                    :active="request()->routeIs('admin.dashboard')"
                                >
                                    <x-icon name="home" size="sm"></x-icon>
                                    <x-sidebar.label>Dashboard</x-sidebar.label>
                                </x-sidebar.item>

                                @if (auth()->user()->canWrite)
                                    <x-sidebar.item
                                        :href="route('admin.writing-overview')"
                                        :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                                    >
                                        <x-icon name="write" size="sm"></x-icon>
                                        <x-sidebar.label>Writing</x-sidebar.label>
                                    </x-sidebar.item>
                                @endif

                                <x-sidebar.item
                                    :href="route('admin.stories.posts-timeline')"
                                    :active="request()->routeIs('admin.stories.*-timeline')"
                                >
                                    <x-icon name="timeline" size="sm"></x-icon>
                                    <x-sidebar.label>Timeline</x-sidebar.label>
                                </x-sidebar.item>
                                <x-sidebar.item
                                    :href="route('admin.notes.index')"
                                    :active="request()->routeIs('admin.notes.*')"
                                >
                                    <x-icon name="note" size="sm"></x-icon>
                                    <x-sidebar.label>Notes</x-sidebar.label>
                                </x-sidebar.item>
                                <x-sidebar.item
                                    :href="route('admin.characters.index')"
                                    :active="$meta->subnavSection === 'characters'"
                                >
                                    <x-icon name="characters" size="sm"></x-icon>
                                    <x-sidebar.label>Characters</x-sidebar.label>
                                </x-sidebar.item>

                                @if (auth()->user()->canManageUsers)
                                    <x-sidebar.item
                                        :href="route('admin.users.index')"
                                        :active="$meta->subnavSection === 'users'"
                                    >
                                        <x-icon name="users" size="sm"></x-icon>
                                        <x-sidebar.label>Users</x-sidebar.label>
                                    </x-sidebar.item>
                                @endif

                                @can('viewAny', Application::class)
                                    <x-sidebar.item
                                        :href="route('admin.applications.index', ['tableFilters' => ['result' => ['values' => ['pending']]]])"
                                        :active="request()->routeIs('admin.applications.*')"
                                    >
                                        <x-icon name="progress-check" size="sm"></x-icon>
                                        <x-sidebar.label>Applications</x-sidebar.label>

                                        @if ($pendingApplicationsCount() > 0)
                                            <x-slot name="trailing">
                                                <x-badge color="warning" class="tabular-nums">
                                                    {{ $pendingApplicationsCount() }}
                                                </x-badge>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.item>
                                @endcan

                                @can('viewAny', Page::class)
                                    <x-sidebar.item
                                        :href="route('admin.pages.index', ['tableFilters' => ['pageType' => ['value' => 0]]])"
                                        :active="request()->routeIs('admin.pages.*')"
                                    >
                                        <x-icon name="www" size="sm"></x-icon>
                                        <x-sidebar.label>Pages</x-sidebar.label>
                                    </x-sidebar.item>
                                @endcan

                                @if (auth()->user()->canManageForms)
                                    <x-sidebar.item
                                        :href="route('admin.forms.index')"
                                        :active="$meta->subnavSection === 'forms'"
                                    >
                                        <x-icon name="form"></x-icon>
                                        <x-sidebar.label>Forms</x-sidebar.label>
                                    </x-sidebar.item>
                                @endif

                                @can('update', $settings)
                                    <x-sidebar.item
                                        :href="route('admin.settings.general.edit')"
                                        :active="$meta->subnavSection === 'settings'"
                                    >
                                        <x-icon name="settings" size="sm"></x-icon>
                                        <x-sidebar.label>Settings</x-sidebar.label>
                                    </x-sidebar.item>
                                @endcan

                                @if (auth()->user()->canManageSystem)
                                    <x-sidebar.item
                                        :href="route('admin.system-overview')"
                                        :active="$meta->subnavSection === 'system'"
                                    >
                                        <x-icon name="server" size="sm"></x-icon>
                                        <x-sidebar.label>System</x-sidebar.label>

                                        @if (cache()->has('nova-update-available') || cache()->has('nova-critical-update-available'))
                                            <x-slot name="trailing">
                                                <div
                                                    @class([
                                                        'text-warning-500' => ! cache()->has('nova-critical-update-available'),
                                                        'text-danger-500' => cache()->has('nova-critical-update-available'),
                                                    ])
                                                >
                                                    <x-icon
                                                        :name="cache()->has('nova-critical-update-available') ? 'update-alert' : 'update'"
                                                        size="sm"
                                                    ></x-icon>
                                                </div>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.item>
                                @endif
                            </x-sidebar.section>

                            <x-sidebar.spacer></x-sidebar.spacer>

                            <x-sidebar.section>
                                <x-sidebar.item href="https://discord.gg/7WmKUks" target="_blank">
                                    <x-icon name="help" size="sm"></x-icon>
                                    <x-sidebar.label>Get help</x-sidebar.label>
                                    <x-slot name="trailing">
                                        <x-icon
                                            name="external"
                                            size="xs"
                                            class="text-gray-400 dark:text-gray-600"
                                        ></x-icon>
                                    </x-slot>
                                </x-sidebar.item>
                            </x-sidebar.section>
                        </x-sidebar.body>

                        <x-sidebar.footer>
                            <x-sidebar.section>
                                <x-dropdown placement="bottom-end" class="w-full">
                                    <x-slot name="emptyTrigger">
                                        <x-sidebar.item>
                                            <x-avatar
                                                :src="auth()->user()->avatar_url"
                                                :tooltip="auth()->user()->name"
                                            />
                                            <x-sidebar.label>{{ auth()->user()->name }}</x-sidebar.label>
                                            <x-icon.chevron-up-down></x-icon.chevron-up-down>
                                        </x-sidebar.item>
                                    </x-slot>

                                    <x-dropdown.group>
                                        <x-dropdown.item :href="route('admin.account.edit')" icon="user">
                                            My account
                                        </x-dropdown.item>
                                        <x-dropdown.item :href="route('admin.account.notifications')" icon="bell">
                                            My notifications
                                        </x-dropdown.item>
                                        <div
                                            class="flex items-center px-4 py-3 text-base text-gray-700 dark:text-gray-300 md:text-sm"
                                        >
                                            <x-icon
                                                name="moon"
                                                size="sm"
                                                class="mr-3 text-gray-500 dark:text-gray-400"
                                            ></x-icon>
                                            <div class="flex w-full items-center justify-between">
                                                <div class="flex-1 font-medium">Dark mode</div>
                                                <livewire:users-admin-theme-toggle />
                                            </div>
                                        </div>
                                    </x-dropdown.group>

                                    <x-dropdown.group>
                                        <x-dropdown.item
                                            :href="route('admin.characters.index', ['tableFilters' => ['only_my_characters' => ['isActive' => true]]])"
                                            icon="characters"
                                        >
                                            My characters
                                        </x-dropdown.item>
                                    </x-dropdown.group>

                                    <x-dropdown.group>
                                        <x-dropdown.item type="submit" icon="logout" form="logout-form">
                                            <span>Sign out</span>

                                            <x-slot name="buttonForm">
                                                <x-form :action="route('logout')" class="hidden" id="logout-form" />
                                            </x-slot>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                </x-dropdown>
                            </x-sidebar.section>
                        </x-sidebar.footer>
                    </x-sidebar>
                </div>

                {{-- Sidebar on mobile --}}
                <div class="relative isolate lg:hidden">
                    <template x-teleport="body">
                        <div
                            class="relative z-10"
                            x-show="open"
                            x-on:keydown.window.escape="open = false"
                            x-cloak
                        >
                            <div
                                class="fixed inset-0 bg-black/25 backdrop-blur"
                                x-transition:enter="duration-300 ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="duration-200 ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                x-show="open"
                            ></div>

                            <div
                                class="fixed inset-y-0 w-full max-w-80 p-2 transition"
                                x-transition:enter="duration-300 ease-in-out"
                                x-transition:enter-start="-translate-x-full"
                                x-transition:enter-end="translate-x-0"
                                x-transition:leave="duration-300 ease-in-out"
                                x-transition:leave-start="translate-x-0"
                                x-transition:leave-end="-translate-x-full"
                                x-show="open"
                                x-trap.noscroll="open"
                            >
                                <div
                                    class="relative z-10 flex h-full flex-col overflow-y-scroll rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                    x-on:click.away="open = false"
                                >
                                    <div class="-mb-3 px-4 pt-3">
                                        <span class="relative">
                                            <button
                                                aria-label="Close navigation"
                                                type="button"
                                                x-on:click="open = false"
                                                class="relative flex min-w-0 cursor-default items-center gap-3 rounded-lg p-2 text-left text-base/6 font-medium text-gray-950 data-[active]:bg-gray-950/5 data-[hover]:bg-gray-950/5 data-[slot=avatar]:*:-m-0.5 data-[slot=avatar]:*:size-7 data-[slot=icon]:*:size-6 data-[slot=icon]:*:shrink-0 data-[slot=icon]:*:data-[active]:fill-gray-950 data-[slot=icon]:*:data-[hover]:fill-gray-950 data-[slot=icon]:*:fill-gray-500 data-[slot=avatar]:*:[--avatar-radius:theme(borderRadius.DEFAULT)] data-[slot=avatar]:*:[--ring-opacity:10%] dark:text-white dark:data-[active]:bg-white/5 dark:data-[hover]:bg-white/5 dark:data-[slot=icon]:*:data-[active]:fill-white dark:data-[slot=icon]:*:data-[hover]:fill-white dark:data-[slot=icon]:*:fill-gray-400 sm:text-sm/5 sm:data-[slot=avatar]:*:size-6 sm:data-[slot=icon]:*:size-5 data-[slot=icon]:last:[&:not(:nth-child(2))]:*:ml-auto data-[slot=icon]:last:[&:not(:nth-child(2))]:*:size-5 sm:data-[slot=icon]:last:[&:not(:nth-child(2))]:*:size-4"
                                            >
                                                <span
                                                    class="absolute left-1/2 top-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 [@media(pointer:fine)]:hidden"
                                                    aria-hidden="true"
                                                ></span>
                                                <x-icon.x></x-icon.x>
                                            </button>
                                        </span>
                                    </div>

                                    <x-sidebar>
                                        <x-sidebar.header>
                                            <x-sidebar.section>
                                                <div class="mb-2 flex px-2">
                                                    <a href="{{ route('admin.dashboard') }}" aria-label="Home">
                                                        @if (app('nova.settings')->getFirstMedia('logo'))
                                                            <img
                                                                src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                                                                alt="logo"
                                                                class="block h-8 w-auto"
                                                            />
                                                        @else
                                                            <x-logos.nova class="h-8 w-auto" />
                                                        @endif
                                                    </a>
                                                </div>
                                            </x-sidebar.section>
                                        </x-sidebar.header>

                                        <x-sidebar.body>
                                            <x-sidebar.section>
                                                <x-sidebar.item
                                                    :href="route('admin.dashboard')"
                                                    :active="request()->routeIs('admin.dashboard')"
                                                >
                                                    <x-icon name="home" size="sm"></x-icon>
                                                    <x-sidebar.label>Dashboard</x-sidebar.label>
                                                </x-sidebar.item>

                                                @if (auth()->user()->canWrite)
                                                    <x-sidebar.item
                                                        :href="route('admin.writing-overview')"
                                                        :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                                                    >
                                                        <x-icon name="write" size="sm"></x-icon>
                                                        <x-sidebar.label>Writing</x-sidebar.label>
                                                    </x-sidebar.item>
                                                @endif

                                                <x-sidebar.item
                                                    :href="route('admin.stories.posts-timeline')"
                                                    :active="request()->routeIs('admin.stories.*-timeline')"
                                                >
                                                    <x-icon name="timeline" size="sm"></x-icon>
                                                    <x-sidebar.label>Timeline</x-sidebar.label>
                                                </x-sidebar.item>
                                                <x-sidebar.item
                                                    :href="route('admin.notes.index')"
                                                    :active="request()->routeIs('admin.notes.*')"
                                                >
                                                    <x-icon name="note" size="sm"></x-icon>
                                                    <x-sidebar.label>Notes</x-sidebar.label>
                                                </x-sidebar.item>
                                                <x-sidebar.item
                                                    :href="route('admin.characters.index')"
                                                    :active="$meta->subnavSection === 'characters'"
                                                >
                                                    <x-icon name="characters" size="sm"></x-icon>
                                                    <x-sidebar.label>Characters</x-sidebar.label>
                                                </x-sidebar.item>

                                                @if (auth()->user()->canManageUsers)
                                                    <x-sidebar.item
                                                        :href="route('admin.users.index')"
                                                        :active="$meta->subnavSection === 'users'"
                                                    >
                                                        <x-icon name="users" size="sm"></x-icon>
                                                        <x-sidebar.label>Users</x-sidebar.label>
                                                    </x-sidebar.item>
                                                @endif

                                                @can('viewAny', Application::class)
                                                    <x-sidebar.item
                                                        :href="route('admin.applications.index', ['tableFilters' => ['result' => ['values' => ['pending']]]])"
                                                        :active="request()->routeIs('admin.applications.*')"
                                                    >
                                                        <x-icon name="progress-check" size="sm"></x-icon>
                                                        <x-sidebar.label>Applications</x-sidebar.label>

                                                        @if ($pendingApplicationsCount() > 0)
                                                            <x-slot name="trailing">
                                                                <x-badge color="warning">
                                                                    {{ $pendingApplicationsCount() }}
                                                                </x-badge>
                                                            </x-slot>
                                                        @endif
                                                    </x-sidebar.item>
                                                @endcan

                                                @can('viewAny', Page::class)
                                                    <x-sidebar.item
                                                        :href="route('admin.pages.index', ['tableFilters' => ['pageType' => ['value' => 0]]])"
                                                        :active="request()->routeIs('admin.pages.*')"
                                                    >
                                                        <x-icon name="www" size="sm"></x-icon>
                                                        <x-sidebar.label>Pages</x-sidebar.label>
                                                    </x-sidebar.item>
                                                @endcan

                                                @if (auth()->user()->canManageForms)
                                                    <x-sidebar.item
                                                        :href="route('admin.forms.index')"
                                                        :active="$meta->subnavSection === 'forms'"
                                                    >
                                                        <x-icon name="form"></x-icon>
                                                        <x-sidebar.label>Forms</x-sidebar.label>
                                                    </x-sidebar.item>
                                                @endif

                                                @can('update', $settings)
                                                    <x-sidebar.item
                                                        :href="route('admin.settings.general.edit')"
                                                        :active="$meta->subnavSection === 'settings'"
                                                    >
                                                        <x-icon name="settings" size="sm"></x-icon>
                                                        <x-sidebar.label>Settings</x-sidebar.label>
                                                    </x-sidebar.item>
                                                @endcan

                                                @if (auth()->user()->canManageSystem)
                                                    <x-sidebar.item
                                                        :href="route('admin.system-overview')"
                                                        :active="$meta->subnavSection === 'system'"
                                                    >
                                                        <x-icon name="server" size="sm"></x-icon>
                                                        <x-sidebar.label>System</x-sidebar.label>

                                                        @if (cache()->has('nova-update-available') || cache()->has('nova-critical-update-available'))
                                                            <x-slot name="trailing">
                                                                <div
                                                                    @class([
                                                                        'text-warning-500' => ! cache()->has('nova-critical-update-available'),
                                                                        'text-danger-500' => cache()->has('nova-critical-update-available'),
                                                                    ])
                                                                >
                                                                    <x-icon
                                                                        :name="cache()->has('nova-critical-update-available') ? 'update-alert' : 'update'"
                                                                        size="sm"
                                                                    ></x-icon>
                                                                </div>
                                                            </x-slot>
                                                        @endif
                                                    </x-sidebar.item>
                                                @endif
                                            </x-sidebar.section>

                                            <x-sidebar.spacer></x-sidebar.spacer>

                                            <x-sidebar.section>
                                                <x-sidebar.item href="https://discord.gg/7WmKUks" target="_blank">
                                                    <x-icon name="help" size="sm"></x-icon>
                                                    <x-sidebar.label>Get help</x-sidebar.label>
                                                    <x-slot name="trailing">
                                                        <x-icon
                                                            name="external"
                                                            size="xs"
                                                            class="text-gray-400 dark:text-gray-600"
                                                        ></x-icon>
                                                    </x-slot>
                                                </x-sidebar.item>
                                            </x-sidebar.section>
                                        </x-sidebar.body>
                                    </x-sidebar>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Header on mobile --}}
                <header class="flex items-center px-4 lg:hidden">
                    <x-navbar>
                        <x-navbar.section>
                            <x-navbar.item x-on:click="open = true" type="button">
                                <svg data-slot="icon" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                                    <path
                                        d="M2 6.75C2 6.33579 2.33579 6 2.75 6H17.25C17.6642 6 18 6.33579 18 6.75C18 7.16421 17.6642 7.5 17.25 7.5H2.75C2.33579 7.5 2 7.16421 2 6.75ZM2 13.25C2 12.8358 2.33579 12.5 2.75 12.5H17.25C17.6642 12.5 18 12.8358 18 13.25C18 13.6642 17.6642 14 17.25 14H2.75C2.33579 14 2 13.6642 2 13.25Z"
                                    />
                                </svg>
                            </x-navbar.item>
                        </x-navbar.section>

                        <x-navbar.spacer></x-navbar.spacer>

                        <x-navbar.section>
                            <x-navbar.item>
                                <x-icon name="search"></x-icon>
                            </x-navbar.item>

                            <x-navbar.item :href="route('admin.messages.index')" class="relative">
                                @if ($unreadMessagesCount() > 0)
                                    <div class="absolute right-0 top-2 size-2 rounded-full bg-primary-500"></div>
                                @endif

                                <x-icon name="inbox"></x-icon>
                            </x-navbar.item>

                            <livewire:users-notifications />

                            <x-navbar.item :href="route('admin.announcements.index')">
                                @if ($unreadAnnouncementsCount() > 0)
                                    <div class="absolute right-0 top-2 size-2 rounded-full bg-primary-500"></div>
                                @endif

                                <x-icon name="megaphone"></x-icon>
                            </x-navbar.item>

                            <x-dropdown placement="bottom-end" class="w-full">
                                <x-slot name="emptyTrigger">
                                    <x-navbar.item>
                                        <x-avatar :src="auth()->user()->avatar_url"></x-avatar>
                                    </x-navbar.item>
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.item :href="route('admin.account.edit')" icon="user">
                                        My account
                                    </x-dropdown.item>
                                    <x-dropdown.item :href="route('admin.account.notifications')" icon="notification">
                                        My notifications
                                    </x-dropdown.item>
                                    <div
                                        class="flex items-center px-4 py-3 text-base text-gray-700 dark:text-gray-300 md:text-sm"
                                    >
                                        <x-icon
                                            name="moon"
                                            size="sm"
                                            class="mr-3 text-gray-500 dark:text-gray-400"
                                        ></x-icon>
                                        <div class="flex w-full items-center justify-between">
                                            <div class="flex-1 font-medium">Dark mode</div>
                                            <livewire:users-admin-theme-toggle />
                                        </div>
                                    </div>
                                </x-dropdown.group>

                                <x-dropdown.group>
                                    <x-dropdown.item
                                        :href="route('admin.characters.index', ['tableFilters' => ['only_my_characters' => ['isActive' => true]]])"
                                        icon="characters"
                                    >
                                        My characters
                                    </x-dropdown.item>
                                </x-dropdown.group>

                                <x-dropdown.group>
                                    <x-dropdown.item type="submit" icon="logout" form="logout-form">
                                        <span>Sign out</span>

                                        <x-slot name="buttonForm">
                                            <x-form :action="route('logout')" class="hidden" id="logout-form" />
                                        </x-slot>
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            </x-dropdown>
                        </x-navbar.section>
                    </x-navbar>
                </header>

                <main class="flex flex-1 flex-col pb-2 lg:min-w-0 lg:pl-64 lg:pr-2 lg:pt-2">
                    <div
                        class="relative grow p-6 lg:rounded-lg lg:bg-white lg:p-10 lg:shadow-sm lg:ring-1 lg:ring-gray-950/5 dark:lg:bg-gray-900 dark:lg:ring-white/10"
                    >
                        <div class="relative z-[2] mx-auto max-w-6xl">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>

            {{ NovaView::renderHook('admin::page.end') }}
        </div>

        @stack('modal')
        @livewire('livewire-ui-spotlight')
        @livewire('wire-elements-modal')
        @livewire('notifications')
        @livewire('scribble.renderer')
        @livewire('scribble.modals')

        {{ NovaView::renderHook('admin::scripts.before') }}

        @filamentScripts(withCore: true)
        @novaAdminScripts
        @stack('scripts')

        {{ NovaView::renderHook('admin::scripts.after') }}
        {{ NovaView::renderHook('admin::body.end') }}
    </body>
</html>
