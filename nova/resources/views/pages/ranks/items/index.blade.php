@extends($meta->template)

@section('content')
    @livewire('rank-items:list')

    <x-tips section="ranks" />

    <x-modal color="danger" title="Delete rank item?" icon="warning" :url="route('ranks.items.delete')">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button.filled type="submit" form="form" color="danger" class="w-full">
                    Delete
                </x-button.filled>
            </span>
            <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                <x-button.outline @click="$dispatch('modal-close')" type="button" color="gray" class="w-full">
                    Cancel
                </x-button.outline>
            </span>
        </x-slot:footer>
    </x-modal>
@endsection
