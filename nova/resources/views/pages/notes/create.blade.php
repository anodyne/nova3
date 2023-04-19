@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new note">
            <x-slot:actions>
                <x-link :href="route('notes.index')" color="gray" leading="arrow-left">
                    Back to my notes
                </x-link>
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('notes.store')">
            <x-content-box class="space-y-8">
                <x-input.group label="Title" for="title" :error="$errors->first('title')" class="sm:w-1/2">
                    <x-input.text id="title" name="title" :value="old('title')" data-cy="title" />
                </x-input.group>

                <x-input.group for="content" :error="$errors->first('editor-content')">
                    <livewire:nova:editor :content="old('editor-content', '')" />
                </x-input.group>
            </x-content-box>

            <x-form.footer>
                <x-button-filled type="submit">Add note</x-button-filled>
                <x-link :href="route('notes.index')" color="gray">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}">
    @endonce
@endpush
