<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.settings.general.edit')"
            :active="request()->routeIs('admin.settings.general.edit')"
        >
            General
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.settings.appearance.edit')"
            :active="request()->routeIs('admin.settings.appearance.edit')"
        >
            Appearance
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.settings.applications.edit')"
            :active="request()->routeIs('admin.settings.applications.edit')"
        >
            Applications
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.settings.characters.edit')"
            :active="request()->routeIs('admin.settings.characters.edit')"
        >
            Characters
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.settings.content-ratings.edit')"
            :active="request()->routeIs('admin.settings.content-ratings.edit')"
        >
            Content ratings
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.settings.email.edit')"
            :active="request()->routeIs('admin.settings.email.edit')"
        >
            Email
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.settings.environment.edit')"
            :active="request()->routeIs('admin.settings.environment.edit')"
        >
            Environment
        </x-sidebar.subnav.item>

        {{-- <x-sidebar.subnav.item href="{{ route('settings.index', 'meta-tags') }}" :active="request()->is('settings/meta-tags')">Meta tags</x-sidebar.subnav.item> --}}

        {{--
            <x-sidebar.subnav.item
            :href="route('admin.settings.posting-activity.edit')"
            :active="request()->routeIs('admin.settings.posting-activity.edit')"
            >
            Posting activity
            </x-sidebar.subnav.item>
        --}}

        <x-sidebar.subnav.item
            :href="route('admin.settings.notifications.edit')"
            :active="request()->routeIs('admin.settings.notifications.edit')"
        >
            Notifications
        </x-sidebar.subnav.item>
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
