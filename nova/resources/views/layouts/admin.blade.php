@use('Nova\Applications\Models\Application')
@use('Nova\Foundation\Enums\ReleaseSeverity')
@use('Nova\Pages\Models\Page')
@use('Nova\Settings\Enums\AvatarShape')
@use('Nova\Stories\Models\Post')

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @class([
        'h-full',
        $appearance(),
    ])
    {{ $themeDataAttribute() }}
>
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
        {{-- class="h-full bg-white font-(family-name:--font-body) text-gray-600 antialiased xl:bg-gray-100 dark:bg-gray-900 dark:text-gray-400 dark:xl:bg-gray-900" --}}
        class="h-svh min-w-[1024px] bg-(--bg-color) font-(family-name:--font-body) text-gray-600 antialiased [--bg-color:var(--color-white)] xl:[--bg-color:var(--color-gray-50)] dark:text-gray-400 dark:[--bg-color:color-mix(in_oklab,var(--color-gray-950),white_10%)]"
        @if (settings('appearance.panda')) data-panda @endif
    >
        {{ NovaView::renderHook('admin::body.start') }}

        <div id="nova">
            {{ NovaView::renderHook('admin::page.start') }}

            <div class="relative flex min-h-svh w-full bg-(--bg-color) max-lg:flex-col" x-data="{ open: false }">
                @if (app('impersonate')->isImpersonating())
                    <div
                        class="pointer-events-none absolute inset-x-0 top-[var(--banner-height)] z-[49] h-9 overflow-hidden drop-shadow-md"
                    >
                        <div class="absolute inset-x-0 top-0 h-1">
                            <div class="absolute -inset-x-2 top-0 flex h-1 w-[calc(100%+2rem)] justify-center">
                                <div
                                    class="h-1 w-full rounded-full bg-[#151718]"
                                    style="opacity: 1; transform: none"
                                ></div>
                            </div>
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 flex origin-top justify-center"
                            style="opacity: 1; transform: none"
                        >
                            <div
                                class="group pointer-events-auto relative mx-auto flex h-9 w-auto cursor-default items-center rounded-b-2xl bg-[#151718] pt-1 text-white"
                            >
                                <svg
                                    class="absolute top-1 -left-4 size-4 text-[#151718]"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path d="M6 0V6C6 2.68652 3.31445 0 0 0H6Z" fill="currentColor"></path>
                                </svg>

                                <svg
                                    class="absolute top-1 -right-4 size-4 text-[#151718]"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path d="M0 0V6C0 2.68652 2.68555 0 6 0H0Z" fill="currentColor"></path>
                                </svg>

                                <div
                                    class="absolute inset-x-1/2 bottom-0 h-16 w-[150%] -translate-x-1/2 overflow-hidden rounded-b-full transition-all duration-500 ease-in-out group-hover:w-[115%]"
                                >
                                    <div
                                        class="bg-gradient-radial absolute inset-x-1/2 bottom-0 h-24 w-[125%] -translate-x-1/2 opacity-50 mix-blend-hard-light"
                                        style="
                                            --tw-gradient-start: rgb(var(--primary-500));
                                            --tw-gradient-end: rgba(var(--primary-500), 0);
                                            background-image: radial-gradient(
                                                47.64% 47.64% at 50% 50%,
                                                var(--tw-gradient-start) 0%,
                                                var(--tw-gradient-end) 100%
                                            );
                                        "
                                    ></div>
                                </div>

                                <div
                                    class="relative flex h-6 items-center overflow-hidden pr-1 pl-1 text-white transition-all duration-500 ease-in-out group-hover:pr-4 group-hover:pl-3"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="size-6"
                                    >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 11h18" />
                                        <path d="M5 11v-4a3 3 0 0 1 3 -3h8a3 3 0 0 1 3 3v4" />
                                        <path d="M7 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M10 17h4" />
                                    </svg>

                                    <a
                                        href="{{ route('impersonate.leave') }}"
                                        class="max-w-0 overflow-hidden text-sm/6 font-medium whitespace-nowrap text-white transition-all duration-700 ease-in-out group-hover:ml-2 group-hover:max-w-sm"
                                    >
                                        Impersonating {{ auth()->user()->name }}. Click to exit.
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

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
                                <flux:modal.trigger name="global-search">
                                    <x-sidebar.old-item type="button" data-tour="dashboard-search">
                                        <x-icon :name="Tabler::Search" />
                                        <x-sidebar.label>Search</x-sidebar.label>
                                    </x-sidebar.old-item>
                                </flux:modal.trigger>

                                @if (Nova::userCount() > 1)
                                    <x-sidebar.old-item
                                        :href="route('admin.messages.index')"
                                        :active="request()->routeIs('admin.messages.*')"
                                        data-tour="dashboard-messages"
                                    >
                                        <x-icon :name="Tabler::Inbox" />
                                        <x-sidebar.label>Messages</x-sidebar.label>

                                        @if ($unreadMessagesCount() > 0)
                                            <x-slot name="trailing">
                                                <x-badge type="square" color="primary">
                                                    {{ $unreadMessagesCount() }}
                                                </x-badge>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.old-item>
                                @endif

                                <x-sidebar.old-item
                                    x-on:click="Livewire.dispatch('slide-over.open', {component: 'users-notifications'})"
                                    data-tour="dashboard-notifications"
                                >
                                    <x-icon :name="Tabler::Bell" />
                                    <x-sidebar.label>Notifications</x-sidebar.label>

                                    @if ($unreadNotificationsCount() > 0)
                                        <x-slot name="trailing">
                                            <x-badge type="square" color="primary">
                                                {{ $unreadNotificationsCount() }}
                                            </x-badge>
                                        </x-slot>
                                    @endif
                                </x-sidebar.old-item>

                                @if (Nova::userCount() > 1)
                                    <x-sidebar.old-item
                                        :href="route('admin.announcements.index')"
                                        :active="request()->routeIs('admin.announcements.*')"
                                    >
                                        <x-icon :name="Tabler::Speakerphone" />
                                        <x-sidebar.label>Announcements</x-sidebar.label>

                                        @if ($unreadAnnouncementsCount() > 0)
                                            <x-slot name="trailing">
                                                <x-badge type="square" color="primary">
                                                    {{ $unreadAnnouncementsCount() }}
                                                </x-badge>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.old-item>
                                @endif

                                @if ($pendingApprovalsCount() > 0)
                                    <x-sidebar.old-item
                                        :href="route('admin.pending-approval')"
                                        :active="request()->routeIs('admin.pending-approval')"
                                    >
                                        <x-icon :name="Tabler::CircleCheck" />
                                        <x-sidebar.label>Pending approval</x-sidebar.label>

                                        <x-slot name="trailing">
                                            <x-badge type="square" color="warning">
                                                {{ $pendingApprovalsCount() }}
                                            </x-badge>
                                        </x-slot>
                                    </x-sidebar.old-item>
                                @endif
                            </x-sidebar.section>
                        </x-sidebar.header>

                        <x-sidebar.body>
                            <x-sidebar.section>
                                <x-sidebar.old-item
                                    :href="route('admin.dashboard')"
                                    :active="request()->routeIs('admin.dashboard')"
                                    data-tour="dashboard"
                                >
                                    <x-icon :name="Tabler::Home" />
                                    <x-sidebar.label>Dashboard</x-sidebar.label>
                                </x-sidebar.old-item>

                                @if (auth()->user()->can_write)
                                    <x-sidebar.old-item
                                        :href="route('admin.writing-overview')"
                                        :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                                        data-tour="writing"
                                    >
                                        <x-icon :name="Tabler::Edit" />
                                        <x-sidebar.label>Write</x-sidebar.label>

                                        @if ($draftPostsNeedingAttentionCount() > 0)
                                            <x-slot name="trailing">
                                                <x-badge type="square" color="warning">
                                                    {{ $draftPostsNeedingAttentionCount() }}
                                                </x-badge>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.old-item>
                                @endif

                                <x-sidebar.old-item
                                    :href="route('admin.stories.posts-timeline')"
                                    :active="request()->routeIs('admin.stories.*-timeline')"
                                >
                                    <x-icon :name="Tabler::TimelineEvent" />
                                    <x-sidebar.label>Timeline</x-sidebar.label>
                                </x-sidebar.old-item>
                                <x-sidebar.old-item
                                    :href="route('admin.notes.index')"
                                    :active="request()->routeIs('admin.notes.*')"
                                >
                                    <x-icon :name="Tabler::Note" />
                                    <x-sidebar.label>Notes</x-sidebar.label>
                                </x-sidebar.old-item>
                                <x-sidebar.old-item
                                    :href="route('admin.characters.index')"
                                    :active="$meta->subnavSection === 'characters'"
                                    data-tour="characters"
                                >
                                    <x-icon :name="Tabler::MasksTheater" />
                                    <x-sidebar.label>Characters</x-sidebar.label>
                                </x-sidebar.old-item>

                                @if (auth()->user()->can_manage_users)
                                    <x-sidebar.old-item
                                        :href="route('admin.users.index')"
                                        :active="$meta->subnavSection === 'users'"
                                        data-tour="users"
                                    >
                                        <x-icon :name="Tabler::Users" />
                                        <x-sidebar.label>Users</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @endif

                                @can('viewAny', Application::class)
                                    <x-sidebar.old-item
                                        :href="route('admin.applications.index', ['tableFilters' => ['result' => ['values' => ['pending']]]])"
                                        :active="request()->routeIs('admin.applications.*')"
                                    >
                                        <x-icon :name="Tabler::ProgressCheck" />
                                        <x-sidebar.label>Applications</x-sidebar.label>

                                        @if ($pendingApplicationsCount() > 0)
                                            <x-slot name="trailing">
                                                <x-badge type="square" color="warning">
                                                    {{ $pendingApplicationsCount() }}
                                                </x-badge>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.old-item>
                                @endcan

                                @can('viewAny', Page::class)
                                    <x-sidebar.old-item
                                        :href="route('admin.pages.index', ['pageType' => 0])"
                                        :active="request()->routeIs('admin.pages.*')"
                                        data-tour="pages"
                                    >
                                        <x-icon :name="Tabler::WorldWww" />
                                        <x-sidebar.label>Pages</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @endcan

                                @if (auth()->user()->can_manage_forms)
                                    <x-sidebar.old-item
                                        :href="route('admin.forms.index')"
                                        :active="$meta->subnavSection === 'forms'"
                                        data-tour="forms"
                                    >
                                        <x-icon :name="Tabler::Forms" />
                                        <x-sidebar.label>Forms</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @else
                                    <x-sidebar.old-item
                                        :href="route('admin.form-submissions.index')"
                                        :active="$meta->subnavSection === 'forms'"
                                    >
                                        <x-icon :name="Tabler::Forms" />
                                        <x-sidebar.label>Forms</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @endif

                                @permission('report.view')
                                    <x-sidebar.old-item
                                        :href="route('admin.reporting.game-overview')"
                                        :active="$meta->subnavSection === 'reporting'"
                                        data-tour="reporting"
                                    >
                                        <x-icon :name="Tabler::ChartDots" />
                                        <x-sidebar.label>Reporting</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @endpermission

                                @can('update', $settings)
                                    <x-sidebar.old-item
                                        :href="route('admin.settings.general.edit')"
                                        :active="$meta->subnavSection === 'settings'"
                                        data-tour="settings"
                                    >
                                        <x-icon :name="Tabler::Settings" />
                                        <x-sidebar.label>Settings</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @endcan

                                @if (auth()->user()->can_manage_system)
                                    <x-sidebar.old-item
                                        :href="route('admin.system-overview')"
                                        :active="$meta->subnavSection === 'system'"
                                        data-tour="system"
                                    >
                                        <x-icon :name="Tabler::Server" />
                                        <x-sidebar.label>System</x-sidebar.label>

                                        @if (! is_null(cache(CacheKeys::UpdateAvailable->value)))
                                            <x-slot name="trailing">
                                                <div
                                                    @class([
                                                        'text-warning-500' => cache(CacheKeys::UpdateAvailable->value) !== ReleaseSeverity::Critical,
                                                        'text-danger-500' => cache(CacheKeys::UpdateAvailable->value) === ReleaseSeverity::Critical,
                                                    ])
                                                >
                                                    <x-icon
                                                        :name="cache(CacheKeys::UpdateAvailable->value) === ReleaseSeverity::Critical ? Tabler::RefreshAlert : Tabler::RefreshDot"
                                                    />
                                                </div>
                                            </x-slot>
                                        @endif
                                    </x-sidebar.old-item>
                                @endif
                            </x-sidebar.section>

                            <x-sidebar.spacer></x-sidebar.spacer>

                            <x-sidebar.section>
                                @if (request()->routeIs('admin.dashboard'))
                                    <x-sidebar.old-item onclick="window.TourManager.start('dashboard-tour')">
                                        <x-icon :name="Tabler::Directions" />
                                        <x-sidebar.label>Take a tour</x-sidebar.label>
                                    </x-sidebar.old-item>
                                @endif

                                <x-sidebar.old-item
                                    :href="external_content('discord')"
                                    target="_blank"
                                    data-tour="dashboard-help"
                                >
                                    <x-icon :name="Tabler::HelpCircle" />
                                    <x-sidebar.label>Get help</x-sidebar.label>
                                    <x-slot name="trailing">
                                        <x-icon
                                            :name="Tabler::ExternalLink"
                                            size="xs"
                                            class="text-gray-400 dark:text-gray-600"
                                        />
                                    </x-slot>
                                </x-sidebar.old-item>
                            </x-sidebar.section>
                        </x-sidebar.body>

                        <x-sidebar.footer>
                            <x-sidebar.section>
                                <x-dropdown placement="top start" class="w-56">
                                    <x-slot name="trigger">
                                        <flux:profile
                                            :name="auth()->user()->name"
                                            :avatar="auth()->user()->avatar_url"
                                            :circle="settings('appearance.avatarShape') === AvatarShape::Circle"
                                            icon:trailing="chevron-up-down"
                                            class="w-full"
                                        ></flux:profile>
                                    </x-slot>

                                    <x-dropdown.item :href="route('admin.account.edit')" :icon="Tabler::User">
                                        My account
                                    </x-dropdown.item>
                                    <x-dropdown.item
                                        :href="route('admin.account.notifications')"
                                        :icon="Tabler::Bell"
                                    >
                                        My notifications
                                    </x-dropdown.item>

                                    <flux:menu.separator />

                                    <div class="dark">
                                        <livewire:users-admin-appearance />
                                    </div>

                                    <flux:menu.separator />

                                    <x-dropdown.item
                                        :href="route('admin.characters.index', ['only_my_characters' => true])"
                                        :icon="Tabler::MasksTheater"
                                    >
                                        My characters
                                    </x-dropdown.item>

                                    <flux:menu.separator />

                                    <x-dropdown.item :post-to-url="route('logout')" :icon="Tabler::Logout">
                                        Sign out
                                    </x-dropdown.item>

                                    {{--
                                        <x-dropdown.group>
                                        
                                        <x-dropdown.item type="div" :icon="Tabler::Moon">
                                        <div class="dark flex w-full items-center justify-between">
                                        <div class="flex-1 font-medium">Dark mode</div>
                                        <flux:switch x-data x-model="$flux.dark" />
                                        </div>
                                        </x-dropdown.item>
                                        
                                        </x-dropdown.group>
                                        
                                        <x-dropdown.group class="dark">
                                        <x-radio.group x-data variant="segmented" x-model="$flux.appearance">
                                        <x-radio value="light" icon="sun" />
                                        <x-radio value="dark" icon="moon" />
                                        <x-radio value="system" icon="computer-desktop" />
                                        </x-radio.group>
                                        </x-dropdown.group>
                                        
                                        <x-dropdown.group>
                                        <x-dropdown.item
                                        :href="route('admin.characters.index', ['only_my_characters' => true])"
                                        :icon="Tabler::MasksTheater"
                                        >
                                        My characters
                                        </x-dropdown.item>
                                        </x-dropdown.group>
                                        
                                        <x-dropdown.group>
                                        <x-dropdown.item type="submit" :icon="Tabler::Logout" form="logout-form">
                                        <span>Sign out</span>
                                        
                                        <x-slot name="buttonForm">
                                        <x-form :action="route('logout')" class="hidden" id="logout-form" />
                                        </x-slot>
                                        </x-dropdown.item>
                                        </x-dropdown.group>
                                    --}}
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
                                                class="relative flex min-w-0 cursor-default items-center gap-3 rounded-lg p-2 text-left text-base/6 font-medium text-gray-950 data-[active]:bg-gray-950/5 data-[hover]:bg-gray-950/5 data-[slot=avatar]:*:-m-0.5 data-[slot=avatar]:*:size-7 data-[slot=avatar]:*:[--avatar-radius:theme(borderRadius.DEFAULT)] data-[slot=avatar]:*:[--ring-opacity:10%] data-[slot=icon]:*:size-6 data-[slot=icon]:*:shrink-0 data-[slot=icon]:*:fill-gray-500 data-[slot=icon]:*:data-[active]:fill-gray-950 data-[slot=icon]:*:data-[hover]:fill-gray-950 sm:text-sm/5 sm:data-[slot=avatar]:*:size-6 sm:data-[slot=icon]:*:size-5 dark:text-white dark:data-[active]:bg-white/5 dark:data-[hover]:bg-white/5 dark:data-[slot=icon]:*:fill-gray-400 dark:data-[slot=icon]:*:data-[active]:fill-white dark:data-[slot=icon]:*:data-[hover]:fill-white data-[slot=icon]:last:[&:not(:nth-child(2))]:*:ml-auto data-[slot=icon]:last:[&:not(:nth-child(2))]:*:size-5 sm:data-[slot=icon]:last:[&:not(:nth-child(2))]:*:size-4"
                                            >
                                                <span
                                                    class="absolute top-1/2 left-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 [@media(pointer:fine)]:hidden"
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
                                                <x-sidebar.old-item
                                                    :href="route('admin.dashboard')"
                                                    :active="request()->routeIs('admin.dashboard')"
                                                >
                                                    <x-icon :name="Tabler::Home" />
                                                    <x-sidebar.label>Dashboard</x-sidebar.label>
                                                </x-sidebar.old-item>

                                                @if (auth()->user()->can_write)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.writing-overview')"
                                                        :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                                                    >
                                                        <x-icon :name="Tabler::Edit" />
                                                        <x-sidebar.label>Write</x-sidebar.label>

                                                        @if ($draftPostsNeedingAttentionCount() > 0)
                                                            <x-slot name="trailing">
                                                                <x-badge type="square" color="warning">
                                                                    {{ $draftPostsNeedingAttentionCount() }}
                                                                </x-badge>
                                                            </x-slot>
                                                        @endif
                                                    </x-sidebar.old-item>
                                                @endif

                                                <x-sidebar.old-item
                                                    :href="route('admin.stories.posts-timeline')"
                                                    :active="request()->routeIs('admin.stories.*-timeline')"
                                                >
                                                    <x-icon :name="Tabler::TimelineEvent" />
                                                    <x-sidebar.label>Timeline</x-sidebar.label>
                                                </x-sidebar.old-item>
                                                <x-sidebar.old-item
                                                    :href="route('admin.notes.index')"
                                                    :active="request()->routeIs('admin.notes.*')"
                                                >
                                                    <x-icon :name="Tabler::Note" />
                                                    <x-sidebar.label>Notes</x-sidebar.label>
                                                </x-sidebar.old-item>
                                                <x-sidebar.old-item
                                                    :href="route('admin.characters.index')"
                                                    :active="$meta->subnavSection === 'characters'"
                                                >
                                                    <x-icon :name="Tabler::MasksTheater" />
                                                    <x-sidebar.label>Characters</x-sidebar.label>
                                                </x-sidebar.old-item>

                                                @if (auth()->user()->can_manage_users)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.users.index')"
                                                        :active="$meta->subnavSection === 'users'"
                                                    >
                                                        <x-icon :name="Tabler::Users" />
                                                        <x-sidebar.label>Users</x-sidebar.label>
                                                    </x-sidebar.old-item>
                                                @endif

                                                @can('viewAny', Application::class)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.applications.index', ['tableFilters' => ['result' => ['values' => ['pending']]]])"
                                                        :active="request()->routeIs('admin.applications.*')"
                                                    >
                                                        <x-icon :name="Tabler::ProgressCheck" />
                                                        <x-sidebar.label>Applications</x-sidebar.label>

                                                        @if ($pendingApplicationsCount() > 0)
                                                            <x-slot name="trailing">
                                                                <x-badge type="square" color="warning">
                                                                    {{ $pendingApplicationsCount() }}
                                                                </x-badge>
                                                            </x-slot>
                                                        @endif
                                                    </x-sidebar.old-item>
                                                @endcan

                                                @can('viewAny', Page::class)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.pages.index', ['pageType' => 0])"
                                                        :active="request()->routeIs('admin.pages.*')"
                                                    >
                                                        <x-icon :name="Tabler::WorldWww" />
                                                        <x-sidebar.label>Pages</x-sidebar.label>
                                                    </x-sidebar.old-item>
                                                @endcan

                                                @if (auth()->user()->can_manage_forms)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.forms.index')"
                                                        :active="$meta->subnavSection === 'forms'"
                                                    >
                                                        <x-icon :name="Tabler::Forms" />
                                                        <x-sidebar.label>Forms</x-sidebar.label>
                                                    </x-sidebar.old-item>
                                                @else
                                                    <x-sidebar.old-item
                                                        :href="route('admin.form-submissions.index')"
                                                        :active="$meta->subnavSection === 'forms'"
                                                    >
                                                        <x-icon :name="Tabler::Forms" />
                                                        <x-sidebar.label>Forms</x-sidebar.label>
                                                    </x-sidebar.old-item>
                                                @endif

                                                @permission('report.view')
                                                    <x-sidebar.old-item
                                                        :href="route('admin.reporting.game-overview')"
                                                        :active="$meta->subnavSection === 'reporting'"
                                                    >
                                                        <x-icon :name="Tabler::ChartDots" />
                                                        <x-sidebar.label>Reporting</x-sidebar.label>
                                                    </x-sidebar.old-item>
                                                @endpermission

                                                @can('update', $settings)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.settings.general.edit')"
                                                        :active="$meta->subnavSection === 'settings'"
                                                    >
                                                        <x-icon :name="Tabler::Settings" />
                                                        <x-sidebar.label>Settings</x-sidebar.label>
                                                    </x-sidebar.old-item>
                                                @endcan

                                                @if (auth()->user()->can_manage_system)
                                                    <x-sidebar.old-item
                                                        :href="route('admin.system-overview')"
                                                        :active="$meta->subnavSection === 'system'"
                                                    >
                                                        <x-icon :name="Tabler::Server" />
                                                        <x-sidebar.label>System</x-sidebar.label>

                                                        @if (! is_null(cache(CacheKeys::UpdateAvailable->value)))
                                                            <x-slot name="trailing">
                                                                <div
                                                                    @class([
                                                                        'text-warning-500' => cache(CacheKeys::UpdateAvailable->value) !== ReleaseSeverity::Critical,
                                                                        'text-danger-500' => cache(CacheKeys::UpdateAvailable->value) === ReleaseSeverity::Critical,
                                                                    ])
                                                                >
                                                                    <x-icon
                                                                        :name="cache(CacheKeys::UpdateAvailable->value) === ReleaseSeverity::Critical ? 'update-alert' : 'update'"
                                                                    />
                                                                </div>
                                                            </x-slot>
                                                        @endif
                                                    </x-sidebar.old-item>
                                                @endif
                                            </x-sidebar.section>

                                            <x-sidebar.spacer></x-sidebar.spacer>

                                            <x-sidebar.section>
                                                <x-sidebar.old-item
                                                    :href="external_content('discord')"
                                                    target="_blank"
                                                >
                                                    <x-icon :name="Tabler::HelpCircle" />
                                                    <x-sidebar.label>Get help</x-sidebar.label>
                                                    <x-slot name="trailing">
                                                        <x-icon
                                                            :name="Tabler::ExternalLink"
                                                            size="xs"
                                                            class="text-gray-400 dark:text-gray-600"
                                                        />
                                                    </x-slot>
                                                </x-sidebar.old-item>
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
                            <x-navbar.item type="button" command="show-modal" commandfor="search-dialog">
                                <x-icon :name="Tabler::Search" />
                            </x-navbar.item>

                            @if (Nova::userCount() > 1)
                                <x-navbar.item :href="route('admin.messages.index')" class="relative">
                                    @if ($unreadMessagesCount() > 0)
                                        <div class="bg-primary-500 absolute top-2 right-0 size-2 rounded-full"></div>
                                    @endif

                                    <x-icon :name="Tabler::Inbox" />
                                </x-navbar.item>
                            @endif

                            <x-navbar.item
                                type="button"
                                x-on:click="Livewire.dispatch('slide-over.open', {component: 'users-notifications'})"
                                aria-label="Notifications"
                            >
                                @if ($unreadNotificationsCount() > 0)
                                    <div class="bg-danger-500 absolute top-2 right-1 size-2 rounded-full"></div>
                                @endif

                                <x-icon :name="Tabler::Bell" />
                            </x-navbar.item>

                            @if (Nova::userCount() > 1)
                                <x-navbar.item :href="route('admin.announcements.index')">
                                    @if ($unreadAnnouncementsCount() > 0)
                                        <div class="bg-primary-500 absolute top-2 right-0 size-2 rounded-full"></div>
                                    @endif

                                    <x-icon :name="Tabler::Speakerphone" />
                                </x-navbar.item>
                            @endif

                            @if ($pendingApprovalsCount() > 0)
                                <x-navbar.item :href="route('admin.pending-approval')">
                                    <div class="bg-warning-500 absolute top-2 right-0 size-2 rounded-full"></div>

                                    <x-icon :name="Tabler::CircleCheck" />
                                </x-navbar.item>
                            @endif

                            <x-dropdown placement="bottom end">
                                <x-slot name="trigger">
                                    <x-navbar.item type="button">
                                        <flux:profile
                                            :avatar="auth()->user()->avatar_url"
                                            :circle="settings('appearance.avatarShape') === AvatarShape::Circle"
                                            icon:trailing="chevron-up-down"
                                        ></flux:profile>
                                    </x-navbar.item>
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.item :href="route('admin.account.edit')" :icon="Tabler::User">
                                        My account
                                    </x-dropdown.item>
                                    <x-dropdown.item
                                        :href="route('admin.account.notifications')"
                                        :icon="Tabler::Notification"
                                    >
                                        My notifications
                                    </x-dropdown.item>
                                    <x-dropdown.item type="div" :icon="Tabler::Moon">
                                        <div class="dark flex w-full items-center justify-between">
                                            <div class="flex-1 font-medium">Dark mode</div>
                                            <flux:switch x-data x-model="$flux.dark" />
                                        </div>
                                    </x-dropdown.item>
                                </x-dropdown.group>

                                <x-dropdown.group>
                                    <x-dropdown.item
                                        :href="route('admin.characters.index', ['only_my_characters' => true])"
                                        :icon="Tabler::MasksTheater"
                                    >
                                        My characters
                                    </x-dropdown.item>
                                </x-dropdown.group>

                                <x-dropdown.group>
                                    <x-dropdown.item :post-to-url="route('logout')" :icon="Tabler::Logout">
                                        Sign out
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            </x-dropdown>
                        </x-navbar.section>
                    </x-navbar>
                </header>

                <main class="flex flex-1 flex-col pb-2 lg:min-w-0 lg:pt-2 lg:pr-2 lg:pl-64">
                    <div
                        class="relative grow p-6 lg:rounded-lg lg:bg-white lg:p-10 lg:shadow-sm lg:ring-1 lg:ring-gray-950/5 dark:lg:bg-gray-950 dark:lg:ring-white/5"
                    >
                        <div class="relative z-[2] mx-auto max-w-6xl">
                            @if ($errors->has('global'))
                                <div class="mb-8">
                                    <x-callout.danger :icon="Tabler::AlertCircle" icon:size="md">
                                        {{ $errors->first('global') }}
                                    </x-callout.danger>
                                </div>
                            @endif

                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>

            {{ NovaView::renderHook('admin::page.end') }}
        </div>

        @stack('modal')
        @livewire('modal-pro')
        @livewire('slide-over-pro')
        @livewire('livewire-ui-spotlight')
        @livewire('notifications')
        @livewire('global-search')

        {{ NovaView::renderHook('admin::scripts.before') }}

        @filamentScripts(withCore: true)
        @fluxScripts
        @novaAdminScripts
        @stack('scripts')

        {{ NovaView::renderHook('admin::scripts.after') }}
        {{ NovaView::renderHook('admin::body.end') }}
    </body>
</html>
