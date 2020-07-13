@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$note->title">
        <x-slot name="pretitle">
            <a href="{{ route('notes.index') }}">Notes</a>
        </x-slot>

        <x-slot name="controls">
            <a href="{{ route('notes.edit', $note) }}" class="button button-primary">
                Edit Note
            </a>
        </x-slot>
    </x-page-header>

    <div class="prose max-w-none">
        {!! $note->content !!}
    </div>
@endsection
