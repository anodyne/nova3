@extends($meta->template)

@section('content')
    <x-page-header :title="$form->name">
        <x-slot:pretitle>
            <a href="{{ route('forms.index') }}">Forms</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('forms.update', $form)" method="PUT" :divide="false" :space="false">
            <x-form.section title="Form Info" message="Officia voluptate adipisicing esse eiusmod incididunt ullamco cupidatat.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text
                        id="name"
                        name="name"
                        :value="old('name', $form->name)"
                        data-cy="name"
                    />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text id="key" name="key" :value="old('key', $form->key)" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="3" data-cy="description">{{ old('description', $form->description) }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-button type="submit" color="primary">Update Form</x-button>
                <x-link :href="route('forms.index')" color="white">Cancel</x-link>
            </x-form.footer>

            <input type="hidden" name="id" value="{{ $form->id }}">
        </x-form>
    </x-panel>
@endsection
