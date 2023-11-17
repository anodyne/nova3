<x-nav.sub>
    <x-nav.sub-group>
        <x-nav.sub-item href="{{ route('system-overview') }}" :active="request()->routeIs('system-overview')">
            Overview
        </x-nav.sub-item>
    </x-nav.sub-group>

    <x-nav.sub-group>
        {{-- <x-nav.sub-item href="#">Pages</x-nav.sub-item> --}}
        {{-- <x-nav.sub-item href="#">Content</x-nav.sub-item> --}}
        {{-- <x-nav.sub-item :href="route('forms.index')" :active="request()->routeIs('forms.*')">Forms</x-nav.sub-item> --}}
        {{-- <x-nav.sub-item href="#">Menus</x-nav.sub-item> --}}
    </x-nav.sub-group>

    <x-nav.sub-group>
        {{-- <x-nav.sub-item href="#">Add-ons</x-nav.sub-item> --}}
        {{--
            <x-nav.sub-item href="{{ route('themes.index') }}" :active="request()->routeIs('themes.*')">
            Themes
            </x-nav.sub-item>
        --}}
    </x-nav.sub-group>

    <x-nav.sub-group>
        @can('viewAny', Spatie\Activitylog\Models\Activity::class)
            <x-nav.sub-item href="{{ route('activity-log.index') }}" :active="request()->routeIs('activity-log.*')">
                Activity log
            </x-nav.sub-item>
        @endcan
    </x-nav.sub-group>
</x-nav.sub>
