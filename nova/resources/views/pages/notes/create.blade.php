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
            <x-form-field
                label="Title"
                field-id="title"
                name="title"
                class="sm:w-1/2"
            >
                <input
                    id="title"
                    type="text"
                    name="title"
                    class="field"
                    value="{{ old('title') }}"
                    data-cy="title"
                >
            </x-form-field>

            <x-form-field
                label="Content"
                field-id="content"
                name="content"
            >
                <x-slot name="clean">
                    <simple-editor height="min-h-48"></simple-editor>
                </x-slot>
            </x-form-field>
        </div>

        <div class="form-footer">
            <button type="submit" class="button button-primary">Add Note</button>

            <a href="{{ route('notes.index') }}" class="button">
                Cancel
            </a>
        </div>
    </form>
</x-panel>
@endsection