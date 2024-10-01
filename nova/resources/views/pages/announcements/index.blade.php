@extends($meta->template)

@use('Nova\Announcements\Models\Announcement')

@section('content')
    <x-page-header>
        <x-slot name="actions">
            @can('create', Announcement::class)
                <x-button :href="route('admin.announcements.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add an announcement
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:announcements-list />

    <x-tips section="announcements"></x-tips>
@endsection
