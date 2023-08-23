@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$note->title">
            <x-slot name="actions">
                <x-button.text :href="route('notes.index')" leading="arrow-left" color="gray">Back</x-button.text>

                <x-button.filled :href="route('notes.edit', $note)" leading="edit" color="primary">
                    Edit
                </x-button.filled>
            </x-slot>
        </x-panel.header>

        <x-content-box>
            <div class="prose max-w-none">
                {!! $note->content !!}
            </div>
        </x-content-box>
    </x-panel>
@endsection
