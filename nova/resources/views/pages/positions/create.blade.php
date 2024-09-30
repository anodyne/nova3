@extends($meta->template)

@use('Nova\Departments\Models\Position')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', Position::class)
                    <x-button
                        :href="$selectedDepartment ? route('admin.positions.index', 'department='.$selectedDepartment?->id) : route('admin.positions.index')"
                        plain
                    >
                        &larr; Back
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.positions.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name')" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Department"
                        name="department_id"
                        id="department_id"
                        :error="$errors->first('department_id')"
                    >
                        <x-select>
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
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="enter"></x-icon>
                    <x-fieldset.legend>Availability</x-fieldset.legend>
                    <x-fieldset.description>
                        You can allow or prevent players from picking this position by setting the number of available
                        slots.

                        @can('update', settings())
                            <x-fieldset.description class="mt-4">
                                Nova can keep the number updated for you as characters are assigned and un-assigned to
                                this position. Go to
                                <x-button :href="route('admin.settings.characters.edit')" color="primary" text>
                                    character settings
                                </x-button>
                                to update your availability settings.
                            </x-fieldset.description>
                        @endcan
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Available Slots" id="available" name="available">
                        <x-input.number :value="old('available', 0)" class="w-full sm:w-1/3"></x-input.number>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.positions.index', 'department='.$selectedDepartment?->id)" plain>
                    Cancel
                </x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
