@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit form">
            <x-slot name="controls">
                @can('viewAny', Nova\Forms\Models\Form::class)
                    <x-button :href="route('forms.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('forms.update', $form)" method="PUT">
            <x-form.section
                title="Form Info"
                message="Officia voluptate adipisicing esse eiusmod incididunt ullamco cupidatat."
            >
                <x-fieldset.field label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $form->name)" data-cy="name" />
                </x-fieldset.field>

                <x-fieldset.field label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text id="key" name="key" :value="old('key', $form->key)" data-cy="key" />
                </x-fieldset.field>

                <x-fieldset.field label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="3" data-cy="description">
                        {{ old('description', $form->description) }}
                    </x-input.textarea>
                </x-fieldset.field>
            </x-form.section>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('forms.index')" plain>Cancel</x-button>
            </x-fieldset.controls>

            <input type="hidden" name="id" value="{{ $form->id }}" />
        </x-form>
    </x-panel>
@endsection
