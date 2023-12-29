@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit department">
            <x-slot name="actions">
                @can('viewAny', Nova\Departments\Models\Department::class)
                    <x-button :href="route('departments.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('departments.update', $department)" method="PUT">
            <x-form.section title="Department info">
                <x-slot name="message">
                    <x-text>
                        Departments are collections of positions that characters can hold and help to provide some
                        organization for your character manifest.
                    </x-text>
                </x-slot>

                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $department->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">
                        {{ old('description', $department->description) }}
                    </x-input.textarea>
                </x-input.group>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', $department->status->value ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.section title="Header image">
                <x-slot name="message">
                    <x-text>
                        Header images are used on the public-facing site to give you more control over the look and feel
                        of your manifest. Header images should be 4 times larger than the size you want to display it at
                        (for high resolution displays), but not more than 5MB in size.
                    </x-text>
                </x-slot>

                <x-input.group>
                    <livewire:media-upload-image :model="$department" media-collection-name="header" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('departments.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
