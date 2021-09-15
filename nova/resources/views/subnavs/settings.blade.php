<x-nav.sub>
    <x-nav.sub-header>Settings</x-nav.sub-header>

    <x-nav.sub-group>
        <x-nav.sub-item href="{{ route('settings.index', 'general') }}" :active="request()->is('settings/general')">General</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'email') }}" :active="request()->is('settings/email')">Email</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'posting-activity') }}" :active="request()->is('settings/posting-activity')">Posting Activity</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'defaults') }}" :active="request()->is('settings/defaults')">Defaults</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'characters') }}" :active="request()->is('settings/characters')">Characters</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'discord') }}" :active="request()->is('settings/discord')">Discord</x-nav.sub-item>
        <x-nav.sub-item href="{{ route('settings.index', 'meta-tags') }}" :active="request()->is('settings/meta-tags')">Meta Tags</x-nav.sub-item>
    </x-nav.sub-group>
</x-nav.sub>