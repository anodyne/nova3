@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header :$meta>
            <x-slot name="actions">
                <x-button :href="route('admin.notes.index')" plain>&larr; Back</x-button>

                <x-button :href="route('admin.notes.edit', $note)" color="primary">
                    <x-icon name="edit" size="sm"></x-icon>
                    Edit
                </x-button>
            </x-slot>
        </x-page-header>

        <x-h2>{{ $note->title }}</x-h2>

        <div class="prose mt-6 max-w-none">
            {!! $note->content !!}
        </div>
    </x-spacing>
@endsection
