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
            <x-slot:actions>
                @can('viewAny', Nova\Forms\Models\Form::class)
                    <x-link :href="route('forms.index')" color="gray" leading="arrow-left">
                        Back to the forms list
                    </x-link>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('forms.store')">
            <x-form.section title="Form Info" message="Laborum esse proident non officia laborum mollit aliqua ad ullamco nisi.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" id="name" name="name" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text x-model="key" @change="suggestKey = false" id="key" name="key" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description') }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button-filled type="submit">Add form</x-button-filled>
                <x-link :href="route('forms.index')" color="gray">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
