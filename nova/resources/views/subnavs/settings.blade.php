<x-nav.sub>
    <x-nav.sub-group>
        <x-nav.sub-item :href="route('settings.general.edit')" :active="request()->routeIs('settings.general.edit')">
            General
        </x-nav.sub-item>
        <x-nav.sub-item
            :href="route('settings.appearance.edit')"
            :active="request()->routeIs('settings.appearance.edit')"
        >
            Appearance
        </x-nav.sub-item>
        <x-nav.sub-item
            :href="route('settings.environment.edit')"
            :active="request()->routeIs('settings.environment.edit')"
        >
            Environment
        </x-nav.sub-item>
        <x-nav.sub-item :href="route('settings.email.edit')" :active="request()->routeIs('settings.email.edit')">
            Email
        </x-nav.sub-item>
        {{-- <x-nav.sub-item href="{{ route('settings.index', 'meta-tags') }}" :active="request()->is('settings/meta-tags')">Meta tags</x-nav.sub-item> --}}
    </x-nav.sub-group>

    <x-nav.sub-group>
        <x-nav.sub-item
            :href="route('settings.content-ratings.edit')"
            :active="request()->routeIs('settings.content-ratings.edit')"
        >
            Content ratings
        </x-nav.sub-item>
        {{--
            <x-nav.sub-item
            :href="route('settings.posting-activity.edit')"
            :active="request()->routeIs('settings.posting-activity.edit')"
            >
            Posting activity
            </x-nav.sub-item>
        --}}
    </x-nav.sub-group>

    <x-nav.sub-group>
        <x-nav.sub-item
            :href="route('settings.characters.edit')"
            :active="request()->routeIs('settings.characters.edit')"
        >
            Characters
        </x-nav.sub-item>
    </x-nav.sub-group>

    <x-nav.sub-group>
        <x-nav.sub-item
            :href="route('settings.notifications.edit')"
            :active="request()->routeIs('settings.notifications.edit')"
        >
            Notifications
        </x-nav.sub-item>
    </x-nav.sub-group>
</x-nav.sub>
