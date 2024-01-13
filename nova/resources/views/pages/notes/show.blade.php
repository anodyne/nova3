@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">{{ $note->title }}</x-slot>

            <x-slot name="actions">
                <x-button :href="route('notes.index')" plain>&larr; Back</x-button>

                <x-button :href="route('notes.edit', $note)" color="primary">
                    <x-icon name="edit" size="sm"></x-icon>
                    Edit
                </x-button>
            </x-slot>
        </x-page-header>

        <div class="prose max-w-none">
            {!! $note->content !!}
        </div>
    </x-spacing>
@endsection
