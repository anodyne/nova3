@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$note->title">
            <x-slot:actions>
                <x-link :href="route('notes.index')" leading="arrow-left" color="gray">
                    Back to my notes
                </x-link>

                <x-button-filled tag="a" :href="route('notes.edit', $note)" leading="edit">
                    Edit
                </x-button-filled>
            </x-slot:actions>
        </x-panel.header>

        <x-content-box>
            <div class="prose max-w-none">
                {!! $note->content !!}
            </div>
        </x-content-box>
    </x-panel>
@endsection
