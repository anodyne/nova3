@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new department">
            <x-slot name="actions">
                @can('viewAny', Nova\Departments\Models\Department::class)
                    <x-button.text :href="route('departments.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('departments.store')">
            <x-form.section
                title="Department Info"
                message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">
                        {{ old('description') }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="status"
                        :value="old('status', 'active')"
                        on-value="active"
                        off-value="inactive"
                    >
                        Active
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Header Image"
                message="Header images are used on the public-facing site to give you more control over the look and feel of your manifest. Header images should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 5MB in size."
            >
                <x-input.group>
                    @livewire('media:upload-image')
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.filled :href="route('departments.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
