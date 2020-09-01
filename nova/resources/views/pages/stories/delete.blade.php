@extends($__novaTemplate)

@section('content')
    <x-page-header title="Delete Story">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <x-form :action="route('stories.destroy')" method="DELETE">
        @livewire('stories:delete-story', ['stories' => $storiesToDelete])

        <x-form.footer>
            <button type="submit" class="button button-primary">Delete @choice('Story|Stories', $storiesToDelete)</button>

            <a href="{{ route('stories.index') }}" class="button">Cancel</a>
        </x-form.footer>
    </x-form>
@endsection
