@extends($meta->template)

@section('content')
    <x-page-header title="Add Department">
        <x-slot:pretitle>
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('departments.store')">
            <x-form.section title="Department Info" message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">{{ old('description') }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="status"
                        :value="old('status', 'active')"
                        active-value="active"
                        inactive-value="inactive"
                    >
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Header Image" message="Header images are used on the public-facing site to give you more control over the look and feel of your manifest. Header images should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 5MB in size.">
                <x-input.group>
                    @livewire('upload-image')
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add Department</x-button>
                <x-link :href="route('departments.index', 'status=active')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
