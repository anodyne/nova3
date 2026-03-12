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
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)"/>
    <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)"/>
    {!! SEO::generate() !!}

    {{ NovaView::renderHook('admin::styles.before') }}

    <x-fonts section="admin"/>
    @filamentStyles
    @novaAdminStyles
    @stack('styles')

    {{ NovaView::renderHook('admin::styles.after') }}
    {{ NovaView::renderHook('admin::head-scripts.before') }}

    @stack('headScripts')

    {{ NovaView::renderHook('admin::head-scripts.after') }}
</head>
<body
    class="relative min-h-screen bg-(--bg-color) font-(family-name:--font-body) text-gray-600 antialiased [--bg-color:var(--color-white)] xl:[--bg-color:var(--color-gray-50)] dark:text-gray-400 dark:[--bg-color:color-mix(in_oklab,var(--color-gray-950),white_10%)]"
>
{{ NovaView::renderHook('admin::body.start') }}

<x-sidebar>
    <x-sidebar.header>
        <x-sidebar.brand
            href="#"
            logo="{{ $logoLightMode() }}"
            logo:dark="{{ $logoDarkMode() }}"
            :name="settings('general.gameName') ?: 'Nova 3'"
        />

        <x-sidebar.collapse/>
    </x-sidebar.header>

    <x-sidebar.nav>
        <x-sidebar.item
            type="button"
            x-on:click="Livewire.dispatch('modal.open', {component: 'global-search'})"
            :icon="Tabler::Search"
            data-tour="dashboard-search"
        >
            Search
        </x-sidebar.item>

        @if (Nova::userCount() > 1)
            <x-sidebar.item
                :href="route('admin.messages.index')"
                :current="request()->routeIs('admin.messages.*')"
                :icon="Tabler::Inbox"
                data-tour="dashboard-messages"
                :badge="$unreadMessagesCount() ?: null"
                badge:color="sky"
            >
                Messages
            </x-sidebar.item>
        @endif

        <x-sidebar.item
            x-on:click="Livewire.dispatch('slide-over.open', {component: 'users-notifications'})"
            :icon="Tabler::Bell"
            data-tour="dashboard-notifications"
            :badge="$unreadNotificationsCount() ?: null"
            badge:color="sky"
        >
            Notifications
        </x-sidebar.item>

        @if (Nova::userCount() > 1)
            <x-sidebar.item
                :href="route('admin.announcements.index')"
                :current="request()->routeIs('admin.announcements.*')"
                :icon="Tabler::Speakerphone"
                :badge="$unreadAnnouncementsCount() ?: null"
                badge:color="sky"
            >
                Announcements
            </x-sidebar.item>
        @endif

        @if ($pendingApprovalsCount() > 0)
            <x-sidebar.item
                :href="route('admin.pending-approval')"
                :current="request()->routeIs('admin.pending-approval')"
                :icon="Tabler::ProgressAlert"
                :badge="$pendingApprovalsCount()"
                badge:color="amber"
            >
                Pending approval
            </x-sidebar.item>
        @endif
    </x-sidebar.nav>

    <x-sidebar.nav>
        <x-sidebar.item
            :href="route('admin.dashboard')"
            :current="request()->routeIs('admin.dashboard')"
            :icon="Tabler::Home"
            data-tour="dashboard"
        >
            Dashboard
        </x-sidebar.item>

        @if (auth()->user()->can_write)
            <x-sidebar.item
                :href="route('admin.writing-overview')"
                :current="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                :icon="Tabler::Edit"
                :badge="$draftPostsNeedingAttentionCount() ?: null"
                badge:color="amber"
                data-tour="writing"
            >
                Write
            </x-sidebar.item>
        @endif

        <x-sidebar.item
            :href="route('admin.stories.posts-timeline')"
            :current="request()->routeIs('admin.stories.*-timeline')"
            :icon="Tabler::TimelineEvent"
        >
            Timeline
        </x-sidebar.item>

        <x-sidebar.item
            :href="route('admin.notes.index')"
            :current="request()->routeIs('admin.notes.*')"
            :icon="Tabler::Note"
        >
            Notes
        </x-sidebar.item>

        <x-sidebar.item
            :href="route('admin.characters.index')"
            :current="$meta->subnavSection === 'characters'"
            :icon="Tabler::MasksTheater"
            data-tour="characters"
        >
            Characters
        </x-sidebar.item>

        @if (auth()->user()->can_manage_users)
            <x-sidebar.item
                :href="route('admin.users.index')"
                :current="$meta->subnavSection === 'users'"
                :icon="Tabler::Users"
                data-tour="users"
            >
                Users
            </x-sidebar.item>
        @endif

        @can('viewAny', Application::class)
            <x-sidebar.item
                :href="route('admin.applications.index', ['tableFilters' => ['result' => ['values' => ['pending']]]])"
                :current="request()->routeIs('admin.applications.*')"
                :icon="Tabler::ProgressCheck"
                :badge="$pendingApplicationsCount() ?: null"
                badge:color="amber"
            >
                Applications
            </x-sidebar.item>
        @endcan

        @can('viewAny', Page::class)
            <x-sidebar.item
                :href="route('admin.pages.index', ['pageType' => 0])"
                :current="request()->routeIs('admin.pages.*')"
                :icon="Tabler::WorldWww"
                data-tour="pages"
            >
                Pages
            </x-sidebar.item>
        @endcan

        @if (auth()->user()->can_manage_forms)
            <x-sidebar.item
                :href="route('admin.forms.index')"
                :current="$meta->subnavSection === 'forms'"
                :icon="Tabler::Forms"
                data-tour="forms"
            >
                Forms
            </x-sidebar.item>
        @else
            <x-sidebar.item
                :href="route('admin.form-submissions.index')"
                :current="$meta->subnavSection === 'forms'"
                :icon="Tabler::Forms"
            >
                Forms
            </x-sidebar.item>
        @endif

        @permission('report.view')
        <x-sidebar.item
            :href="route('admin.reporting.game-overview')"
            :current="$meta->subnavSection === 'reporting'"
            :icon="Tabler::ChartDots"
            data-tour="reporting"
        >
            Reporting
        </x-sidebar.item>
        @endpermission

        @can('update', $settings)
            <x-sidebar.item
                :href="route('admin.settings.general.edit')"
                :current="$meta->subnavSection === 'settings'"
                :icon="Tabler::Settings"
                data-tour="settings"
            >
                Settings
            </x-sidebar.item>
        @endcan

        @if (auth()->user()->can_manage_system)
            <x-sidebar.item
                :href="route('admin.system-overview')"
                :current="$meta->subnavSection === 'system'"
                :icon="Tabler::Server"
                data-tour="system"
            >
                System

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
            </x-sidebar.item>
        @endif
    </x-sidebar.nav>

    <x-sidebar.spacer/>

    <x-sidebar.nav>
        @if (request()->routeIs('admin.dashboard'))
            <x-sidebar.item onclick="window.TourManager.start('dashboard-tour')" :icon="Tabler::Directions">
                Take a tour
            </x-sidebar.item>
        @endif

        <x-sidebar.item
            :href="external_content('discord')"
            target="_blank"
            :icon="Tabler::HelpCircle"
            data-tour="dashboard-help"
        >
            <div class="flex items-center justify-between">
                Get help
                <x-icon :name="Tabler::ExternalLink" size="xs"/>
            </div>
        </x-sidebar.item>
    </x-sidebar.nav>

    <x-dropdown position="top" align="start" class="max-lg:hidden">
        <x-slot name="trigger">
            <flux:sidebar.profile
                :avatar="auth()->user()->avatar_url"
                :name="auth()->user()->name"
                :circle="settings('appearance.avatarShape') === AvatarShape::Circle"
                icon:trailing="chevron-up-down"
            />
        </x-slot>

        <x-dropdown.item :href="route('admin.account.edit')" :icon="Tabler::User">My account</x-dropdown.item>
        <x-dropdown.item :href="route('admin.account.notifications')" :icon="Tabler::Bell">
            My notifications
        </x-dropdown.item>

        <flux:menu.separator/>

        <livewire:users-admin-appearance/>

        <flux:menu.separator/>

        <x-dropdown.item
            :href="route('admin.characters.index', ['only_my_characters' => true])"
            :icon="Tabler::MasksTheater"
        >
            My characters
        </x-dropdown.item>

        <flux:menu.separator/>

        <x-dropdown.item :post-to-url="route('logout')" :icon="Tabler::Logout">Sign out</x-dropdown.item>
    </x-dropdown>
</x-sidebar>

<main class="flex flex-1 flex-col pb-2 [grid-area:main] lg:min-w-0 lg:pt-2 lg:pr-2" data-flux-main>
    <div
        class="relative grow lg:rounded-xl lg:bg-white lg:shadow-sm lg:ring-1 lg:ring-gray-950/5 dark:lg:bg-gray-950 dark:lg:ring-white/5"
    >
        <div class="p-6 lg:p-8">
            <div class="relative mx-auto max-w-6xl">
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
    </div>
</main>

{{ NovaView::renderHook('admin::page.end') }}

@stack('modal')
@livewire('modal-pro')
@livewire('slide-over-pro')
@livewire('livewire-ui-spotlight')
@livewire('notifications')

{{ NovaView::renderHook('admin::scripts.before') }}

@filamentScripts(withCore: true)
@fluxScripts
@novaAdminScripts
@stack('scripts')

{{ NovaView::renderHook('admin::scripts.after') }}
{{ NovaView::renderHook('admin::body.end') }}
</body>
</html>
