@extends($meta->template)

@section('content')
    <x-page-header title="Post Types">
        <x-slot:controls>
            @can('create', 'Nova\PostTypes\Models\PostType')
                <x-link :href="route('post-types.create')" color="blue" data-cy="create">
                    Add Post Type
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    @livewire('post-types:list')

    <x-tips section="post-types" />

    <x-modal color="red" title="Delete Post Type?" icon="warning" :url="route('post-types.delete')">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form" color="red" full-width>
                    Delete
                </x-button>
            </span>
            <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                    Cancel
                </x-button>
            </span>
        </x-slot:footer>
    </x-modal>
@endsection
