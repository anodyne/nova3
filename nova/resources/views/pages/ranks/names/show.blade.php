@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$name->name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.names.index') }}">Rank Names</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $name)
                <a href="{{ route('ranks.names.edit', $name) }}" class="button button-primary">Edit Rank Name</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form.section title="Rank Name Info" message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system.">
            <x-input.group label="Name">
                <p class="font-semibold">{{ $name->name }}</p>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned this name.">
            Coming soon...
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('ranks.names.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
