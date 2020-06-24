@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('departments.update', $department)" method="PUT">
            <x-form.section title="Department Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $department->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">{{ old('description', $department->description) }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $department->active ?? '')"
                        active-text="Active"
                        inactive-text="Inactive"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Department</button>

                <a href="{{ route('departments.index', 'status=active') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
