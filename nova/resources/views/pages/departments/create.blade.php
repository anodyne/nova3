@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Department">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>
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
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Department</button>

                <a href="{{ route('departments.index', 'status=active') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
