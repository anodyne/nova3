@extends($__novaTemplate)

@section('content')
    <x-page-header title="Delete Story">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <x-form :action="route('stories.destroy')" method="DELETE" :divide="false">
        @livewire('stories:delete-story', ['stories' => $storiesToDelete])

        <x-form.footer>
            <x-button type="submit" color="blue">Delete @choice('Story|Stories', $storiesToDelete)</x-button>
            <x-button-link :href="route('stories.index')" color="white">Cancel</x-button-link>
        </x-form.footer>
    </x-form>
@endsection
