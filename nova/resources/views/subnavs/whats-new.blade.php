<x-nav.sub>
    <x-nav.sub-group>
        <x-nav.sub-item :href="route('whats-new')" :current="request()->input('feature', 'overview') === 'overview'">
            Overview
        </x-nav.sub-item>

        {{--
            <x-nav.sub-item :href="route('whats-new', 'feature=applications')" :current="request()->is('whats-new?feature=applications')">
            Applications
            </x-nav.sub-item>
        --}}

        <x-nav.sub-item
            :href="route('whats-new', 'feature=characters')"
            :current="request()->input('feature', 'overview') === 'characters'"
        >
            Characters
        </x-nav.sub-item>

        <x-nav.sub-item
            :href="route('whats-new', 'feature=ranks')"
            :current="request()->input('feature', 'overview') === 'ranks'"
        >
            Ranks
        </x-nav.sub-item>

        <x-nav.sub-item
            :href="route('whats-new', 'feature=stories')"
            :current="request()->input('feature', 'overview') === 'stories'"
        >
            Storytelling
        </x-nav.sub-item>

        <x-nav.sub-item
            :href="route('whats-new', 'feature=users')"
            :current="request()->input('feature', 'overview') === 'users'"
        >
            Users
        </x-nav.sub-item>
    </x-nav.sub-group>
</x-nav.sub>
