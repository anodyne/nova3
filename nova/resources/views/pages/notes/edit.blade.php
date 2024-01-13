@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Edit note</x-slot>

            <x-slot name="actions">
                <x-button :href="route('notes.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <x-form :action="route('notes.update', $note)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Title" id="title" name="title" :error="$errors->first('title')">
                        <x-input.text :value="old('title', $note->title)" data-cy="title" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.field id="content" name="content" :error="$errors->first('editor-content')">
                    <x-editor :value="old('editor-content', $note->content)"></x-editor>
                </x-fieldset.field>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('notes.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
