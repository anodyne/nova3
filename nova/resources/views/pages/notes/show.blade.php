@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$note->title">
            <x-slot:actions>
                <x-button.text :href="route('notes.index')" leading="arrow-left" color="gray">
                    Back
                </x-button.text>

                <x-button.filled :href="route('notes.edit', $note)" leading="edit">
                    Edit
                </x-button.filled>
            </x-slot:actions>
        </x-panel.header>

        <x-content-box>
            <div class="prose max-w-none">
                {!! $note->content !!}
            </div>
        </x-content-box>
    </x-panel>
@endsection
