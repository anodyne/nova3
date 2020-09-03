@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$note->title">
        <x-slot name="pretitle">
            <a href="{{ route('notes.index') }}">Notes</a>
        </x-slot>

        <x-slot name="controls">
            <x-button-link :href="route('notes.edit', $note)" color="blue">
                Edit Note
            </x-button-link>
        </x-slot>
    </x-page-header>

    <div class="prose max-w-none">
        {!! $note->content !!}
    </div>
@endsection
