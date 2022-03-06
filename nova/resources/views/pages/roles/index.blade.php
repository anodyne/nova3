@extends($meta->template)

@section('content')
    <x-page-header title="Roles">
        <x-slot:controls>
            @can('create', 'Nova\Roles\Models\Role')
                <x-link :href="route('roles.create')" color="blue" data-cy="create">
                    Add Role
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    @livewire('roles:list')

    <x-tips section="roles" />

    <x-modal color="red" title="Delete Role?" icon="warning" :url="route('roles.delete')">
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
