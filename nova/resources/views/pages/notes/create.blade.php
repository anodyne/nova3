@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Note">
        <x-slot name="pretitle">
            <a href="{{ route('notes.index') }}">Notes</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <form action="{{ route('notes.store') }}" method="POST" role="form" data-cy="form">
            @csrf

            <div class="px-4 pt-4 | sm:pt-6 sm:px-6">
                <x-input.group label="Title" for="title" :error="$errors->first('title')" class="sm:w-1/2">
                    <x-input.text id="title" name="title" :value="old('title')" data-cy="title" />
                </x-input.group>

                <x-input.group label="Content" for="content" :error="$errors->first('content')">
                    <simple-editor height="min-h-48" value="{{ old('content') }}"></simple-editor>
                </x-input.group>
            </div>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Note</button>

                <a href="{{ route('notes.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </form>
    </x-panel>
@endsection