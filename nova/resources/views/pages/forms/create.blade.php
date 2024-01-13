@extends($meta->template)

@section('content')
    <x-panel
        x-data="{ name: '{{ old('name') }}', key: '{{ old('key') }}', suggestKey: true }"
        x-init="$watch('name', value => {
            if (suggestKey) {
                key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
    >
        <x-panel.header title="Add a new form">
            <x-slot>
                @can('viewAny', Nova\Forms\Models\Form::class)
                    <x-button :href="route('forms.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('forms.store')">
            <x-form.section
                title="Form Info"
                message="Laborum esse proident non officia laborum mollit aliqua ad ullamco nisi."
            >
                <x-fieldset.field label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" id="name" name="name" data-cy="name" />
                </x-fieldset.field>

                <x-fieldset.field label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text x-model="key" @change="suggestKey = false" id="key" name="key" data-cy="key" />
                </x-fieldset.field>

                <x-fieldset.field label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">
                        {{ old('description') }}
                    </x-input.textarea>
                </x-fieldset.field>
            </x-form.section>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('forms.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-panel>
@endsection
