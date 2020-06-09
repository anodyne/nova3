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

    <x-under-construction feature="My Notes">
        <li>There are known issues with the display of HTML created with the rich text editor</li>
    </x-under-construction>

    <x-panel>
        <div class="px-4 pt-4 | sm:pt-6 sm:px-6">
            <div class="trix-content">
                {!! $note->content !!}
            </div>
        </div>

        <x-form.footer>
            <a href="{{ route('notes.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
