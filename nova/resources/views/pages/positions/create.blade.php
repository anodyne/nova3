@use('Nova\Departments\Models\Position')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Position::class)
                <x-slot name="actions">
                    <x-button
                        :href="$selectedDepartment ? route('admin.positions.index', 'department='.$selectedDepartment?->id) : route('admin.positions.index')"
                        variant="ghost"
                        inset="right"
                    >
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.positions.store')">
            <x-fieldset>
                <x-fieldset.fields constrained>
                    <x-input label="Name" name="name" :value="old('name')" />

                    <x-select label="Department" name="department_id">
                        <option value="">Select a department</option>
                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                @selected($department->id === old('department_id', $selectedDepartment?->id))
                            >
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-textarea label="Description" name="description" rows="5">
                        {{ old('description') }}
                    </x-textarea>

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />

                    <x-textarea
                        label="Tags"
                        description="A comma-separated list of tags that can be used for organizing your manifest(s)"
                        name="tags"
                        rows="2"
                    >
                        {{ old('tags') }}
                    </x-textarea>
                </x-fieldset.fields>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon :name="Tabler::DoorEnter"></x-icon>
                    <x-fieldset.legend>Availability</x-fieldset.legend>
                    <x-fieldset.description>
                        You can allow or prevent players from picking this position by setting the number of available
                        slots.

                        @can('update', settings())
                            <x-fieldset.description class="mt-4">
                                Nova can keep the number of available slots for a position updated for you as characters
                                are assigned and un-assigned to the position. You can update the availability settings
                                for individual character types from Character Settings.
                            </x-fieldset.description>

                            <x-button :href="route('admin.settings.characters.edit')" class="mt-4">
                                Go to character settings
                                <span aria-hidden="true">→</span>
                            </x-button>
                        @endcan
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.fields constrained>
                    <div class="w-full sm:w-1/2">
                        <x-input.number label="Available Slots" name="available" :value="old('available', 0)" />
                    </div>
                </x-fieldset.fields>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button
                    :href="route('admin.positions.index', 'department='.$selectedDepartment?->id)"
                    variant="ghost"
                >
                    Cancel
                </x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
