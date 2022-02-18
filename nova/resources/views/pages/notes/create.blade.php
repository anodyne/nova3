@extends($meta->template)

@section('content')
    <x-page-header title="Add Note">
        <x-slot:pretitle>
            <a href="{{ route('notes.index') }}">Notes</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('notes.store')">
            <x-content-box class="space-y-8">
                <x-input.group label="Title" for="title" :error="$errors->first('title')" class="sm:w-1/2">
                    <x-input.text id="title" name="title" :value="old('title')" data-cy="title" />
                </x-input.group>

                <x-input.group label="Summary" for="summary" :error="$errors->first('summary')" class="sm:w-1/2">
                    <x-input.textarea id="summary" name="summary" rows="3" data-cy="summary">{{ old('summary') }}</x-input.textarea>
                </x-input.group>

                <x-input.group for="content" :error="$errors->first('content')">
                    @livewire('nova:editor', ['content' => old('content', '')])
                </x-input.group>
            </x-content-box>

            <x-form.footer>
                <x-button type="submit" color="blue">Add Note</x-button>
                <x-link :href="route('notes.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}">
    @endonce
@endpush