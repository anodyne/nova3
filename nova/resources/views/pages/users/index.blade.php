@extends($meta->template)

@section('content')
    <x-page-header title="All Users">
        <x-slot:controls>
            @can('create', 'Nova\Users\Models\User')
                <x-link :href="route('users.create')" color="blue" data-cy="create">
                    Add User
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    @livewire('users:list')

    <x-tips section="users" />

    <x-modal color="red" title="Delete User?" icon="warning" :url="route('users.delete')">
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

    <x-modal color="red" title="Deactivate User?" icon="remove" :url="route('users.confirm-deactivate')" event="modal-deactivate">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form-deactivate" color="red" full-width>
                    Deactivate
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
