@extends($meta->template)

@section('content')
    <x-page-header title="Delete Story">
        <x-slot:pretitle>
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-form :action="route('stories.destroy')" method="DELETE" :divide="false">
        @livewire('stories:delete-story', ['stories' => $storiesToDelete])

        <x-form.footer>
            <x-button type="submit" color="primary">Delete @choice('Story|Stories', $storiesToDelete)</x-button>
            <x-link :href="route('stories.index')" color="white">Cancel</x-link>
        </x-form.footer>
    </x-form>
@endsection
