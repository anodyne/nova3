@extends($meta->template)

@section('content')
    @livewire('forms:list')

    <x-tips section="forms" />

    <x-modal color="danger" title="Delete form?" icon="warning" :url="route('forms.delete')">
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
@endsection
