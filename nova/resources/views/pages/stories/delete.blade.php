@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header :$meta>
            <x-slot name="actions">
                @can('viewAny', $storiesToDelete->first())
                    <x-button :href="route('admin.stories.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>
    </x-spacing>

    <livewire:stories-delete :stories="$storiesToDelete" />
@endsection
