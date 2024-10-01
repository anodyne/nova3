@extends($meta->template)

@use('Nova\Stories\Models\PostType')

@section('content')
    <x-page-header>
        <x-slot name="actions">
            @can('create', PostType::class)
                <x-button :href="route('admin.post-types.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:post-types-list />

    <x-tips section="post-types" />
@endsection
