<x-nav.sub>
    <x-nav.sub-header>Settings</x-nav.sub-header>

    <x-nav.sub-group>
        <x-nav.sub-item href="{{ route('settings.index', 'general') }}" :active="request()->is('settings/general')">General</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'appearance') }}" :active="request()->is('settings/appearance')">Appearance</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'email') }}" :active="request()->is('settings/email')">Email</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'meta-tags') }}" :active="request()->is('settings/meta-tags')">Meta tags</x-nav.sub-item>
    </x-nav.sub-group>

    <x-nav.sub-group>
        <x-nav.sub-item href="{{ route('settings.index', 'ratings') }}" :active="request()->is('settings/ratings')">Content ratings</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'posting-activity') }}" :active="request()->is('settings/posting-activity')">Posting activity</x-nav.sub-item>
    </x-nav.sub-group>

    <x-nav.sub-group>
        <x-nav.sub-item href="{{ route('settings.index', 'characters') }}" :active="request()->is('settings/characters')">Characters</x-nav.sub-item>
    </x-nav.sub-group>

    <x-nav.sub-group>
        <x-nav.sub-item href="{{ route('settings.index', 'notifications') }}" :active="request()->is('settings/notifications')">Notifications</x-nav.sub-item>
    </x-nav.sub-group>
</x-nav.sub>
