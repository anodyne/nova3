<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button :href="route('admin.notes.index')" variant="ghost" inset="right">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.notes.update', $note)" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Title" name="title" :value="old('title', $note->title)" />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-editor name="content" :value="old('content', $note->content)"></x-editor>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.notes.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
