@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>
    </x-page-header>

    <x-panel x-data="{}">
        <div>
            <div class="p-4 | sm:hidden">
                <select x-on:change="window.location = $event.target.value" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm transition ease-in-out duration-150">
                    <option value="{{ route('departments.edit', $department) }}">Department Info</option>
                    <option value="{{ route('positions.index', $department) }}">Positions</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('departments.edit', $department) }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm border-blue-500 text-blue-600 focus:outline-none"
                        >
                            Department Info
                        </a>
                        <a
                            href="{{ route('positions.index', $department) }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none"
                        >
                            Positions
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <x-form :action="route('departments.update', $department)" method="PUT">
            <x-form.section title="Department Info" message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest.">
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

            <x-form.section title="Header Image" message="Header images are used on the public-facing site to give you more control over the look and feel of your manifest. Header images should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 5MB in size.">
                <x-input.group>
                    @livewire('upload-image')
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Department</button>

                <a href="{{ route('departments.index', 'status=active') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
