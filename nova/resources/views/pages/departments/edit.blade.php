@extends($meta->template)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot:pretitle>
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel x-data="{}">
        <div>
            <div class="p-4 sm:hidden">
                <select @change="window.location = $event.target.value" aria-label="Selected tab" class="mt-1 form-select bg-gray-1 block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 sm:text-sm transition ease-in-out duration-200">
                    <option value="{{ route('departments.edit', $department) }}">Details</option>
                    <option value="{{ route('positions.index', $department) }}">Positions</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-6 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('departments.edit', $department) }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm border-blue-7 text-blue-11 focus:outline-none"
                        >
                            Details
                        </a>
                        <a
                            href="{{ route('positions.index', $department) }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-9 hover:text-gray-11 hover:border-gray-6 focus:outline-none"
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
                    <x-input.toggle field="active" :value="old('active', $department->active ?? '')">
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
                <x-button type="submit" color="blue">Update Department</x-button>
                <x-link :href="route('departments.index', 'status=active')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
