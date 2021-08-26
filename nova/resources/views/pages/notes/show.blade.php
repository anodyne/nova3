@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$note->title">
        <x-slot name="pretitle">
            <a href="{{ route('notes.index') }}">Notes</a>
        </x-slot>

        <x-slot name="controls">
            <x-link :href="route('notes.edit', $note)" color="blue">
                Edit Note
            </x-link>
        </x-slot>
    </x-page-header>

    <x-panel>
        <div class="px-4 py-2 | sm:px-6 sm:py-3">
            <div class="prose max-w-none">
                {!! $note->content !!}
            </div>
        </div>
    </x-panel>

@endsection
