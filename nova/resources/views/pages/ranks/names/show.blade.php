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

        <x-form.section title="Assigned Ranks" message="These are the rank items that have been assigned this rank name.">
            <div class="flex flex-col w-full">
                @foreach ($name->ranks as $rank)
                    <div class="group flex items-center justify-between py-2 px-4 rounded even:bg-gray-100">
                        <div class="flex flex-col | sm:flex-row sm:items-center">
                            <x-rank :rank="$rank" />
                            <span class="font-medium ml-3">{{ optional($rank->group)->name }}</span>
                        </div>
                        @can('update', $rank)
                            <a href="{{ route('ranks.items.edit', $rank) }}" class="text-gray-500 transition ease-in-out duration-150 hover:text-gray-700 group-hover:visible | sm:invisible">
                                @icon('edit')
                            </a>
                        @endcan
                    </div>
                @endforeach
            </div>
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('ranks.names.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
