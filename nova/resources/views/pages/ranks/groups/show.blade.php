@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$group->name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.groups.index') }}">Rank Groups</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $group)
                <a href="{{ route('ranks.groups.edit', $group) }}" class="button button-primary">Edit Rank Group</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
            <x-input.group label="Name">
                <p class="font-semibold">{{ $group->name }}</p>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned to this group.">
            Coming soon...
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('ranks.groups.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
