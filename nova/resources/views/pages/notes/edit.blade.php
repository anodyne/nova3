@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit note">
            <x-slot:actions>
                <x-button :href="route('notes.index')" color="neutral" plain>&larr; Back</x-button>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('notes.update', $note)" method="PUT">
            <x-content-box class="space-y-8">
                <x-input.group label="Title" for="title" :error="$errors->first('title')" class="sm:w-1/2">
                    <x-input.text id="title" name="title" :value="old('title', $note->title)" data-cy="title" />
                </x-input.group>

                <x-input.group for="content" :error="$errors->first('editor-content')">
                    <x-editor :value="old('editor-content', $note->content)"></x-editor>
                </x-input.group>
            </x-content-box>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('notes.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
