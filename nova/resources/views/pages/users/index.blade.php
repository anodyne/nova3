@extends($meta->template)

@section('content')
    @livewire('users:list')

    <x-tips section="users" />

    <x-modal color="danger" title="Delete User?" icon="warning" :url="route('users.delete')">
        <x-slot name="footer">
            <span class="flex w-full sm:col-start-2">
                <x-button.filled type="submit" form="form" color="danger" class="w-full">Delete</x-button.filled>
            </span>
            <span class="mt-3 flex w-full sm:col-start-1 sm:mt-0">
                <x-button.filled x-on:click="$dispatch('modal-close')" type="button" color="neutral" class="w-full">
                    Cancel
                </x-button.filled>
            </span>
        </x-slot>
    </x-modal>

    <x-modal
        color="danger"
        title="Deactivate User?"
        icon="remove"
        :url="route('users.confirm-deactivate')"
        event="modal-deactivate"
    >
        <x-slot name="footer">
            <span class="flex w-full sm:col-start-2">
                <x-button.filled type="submit" form="form-deactivate" color="danger" class="w-full">
                    Deactivate
                </x-button.filled>
            </span>
            <span class="mt-3 flex w-full sm:col-start-1 sm:mt-0">
                <x-button.filled x-on:click="$dispatch('modal-close')" type="button" color="neutral" class="w-full">
                    Cancel
                </x-button.filled>
            </span>
        </x-slot>
    </x-modal>
@endsection
