@extends($meta->template)

@use('Nova\Departments\Models\Department')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new department</x-slot>

            <x-slot name="actions">
                @can('viewAny', Department::class)
                    <x-button :href="route('departments.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('departments.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name')" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Description" id="description" name="description">
                        <x-input.textarea rows="5">
                            {{ old('description') }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', 'active')"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-fieldset.label for="status">Active</x-fieldset.label>
                    </div>

                    <x-fieldset.field
                        label="Tags"
                        description="A comma-separated list of tags that can be used for organizing your manifest(s)"
                        id="tags"
                        name="tags"
                    >
                        <x-input.textarea rows="2">
                            {{ old('tags') }}
                        </x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="image"></x-icon>
                    <x-fieldset.legend>Header image</x-fieldset.legend>
                    <x-fieldset.description>
                        Header images are used on the public-facing site to give you more control over the look and feel
                        of your manifest. Header images should be 4 times larger than the size you want to display it at
                        (for high resolution displays), but not more than 5MB in size.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <livewire:media-upload-image />
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('departments.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
