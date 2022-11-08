@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$note->title">
            <x-slot:controls>
                <x-link :href="route('notes.index')">
                    All notes
                </x-link>

                <x-link :href="route('notes.edit', $note)" color="primary">
                    Edit note
                </x-link>
            </x-slot:controls>
        </x-panel.header>

        <x-content-box>
            <div class="prose max-w-none">
                {!! $note->content !!}
            </div>
        </x-content-box>
    </x-panel>
@endsection
