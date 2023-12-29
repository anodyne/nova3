@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$note->title">
            <x-slot name="actions">
                <x-button :href="route('notes.index')" color="neutral" plain>&larr; Back</x-button>

                <x-button :href="route('notes.edit', $note)" color="primary">
                    <x-icon name="edit" size="sm"></x-icon>
                    Edit
                </x-button>
            </x-slot>
        </x-panel.header>

        <x-content-box>
            <div class="prose max-w-none">
                {!! $note->content !!}
            </div>
        </x-content-box>
    </x-panel>
@endsection
