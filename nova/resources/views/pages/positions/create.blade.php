@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new position">
            <x-slot name="actions">
                @can('viewAny', Nova\Departments\Models\Position::class)
                    <x-button.text
                        :href="$selectedDepartment ? route('positions.index', 'department='.$selectedDepartment?->id) : route('positions.index')"
                        leading="arrow-left"
                        color="gray"
                    >
                        Back
                    </x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('positions.store')">
            <x-form.section
                title="Position Info"
                message="Positions are the jobs or stations that characters can be assigned to for display on your manifests."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Department" for="department_id" :error="$errors->first('department_id')">
                    <x-input.select name="department_id" id="department_id" class="w-full sm:w-2/3">
                        <option value="">Select a department</option>
                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                @selected($department->id === old('department_id', $selectedDepartment?->id))
                            >
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </x-input.select>
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

            <x-form.section title="Availability">
                <x-slot name="message">
                    <p>
                        You can allow or prevent prospective players from picking this position when applying to join by
                        setting the number of available slots.
                    </p>

                    @can('update', settings())
                        <p class="block">
                            <strong class="font-semibold">Note:</strong>
                            After setting this number, Nova can keep the number updated for you as characters are
                            assigned and un-assigned to this position.
                        </p>

                        <x-button.filled :href="route('settings.index', 'characters')" color="gray">
                            Manage character settings
                        </x-button.filled>
                    @endcan
                </x-slot>

                <x-input.group label="Available Slots" for="available">
                    <div class="w-full sm:w-1/3">
                        <x-input.number id="available" name="available" :value="old('available', 0)" />
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.filled :href="route('positions.index', 'department='.$selectedDepartment?->id)" color="gray">
                    Cancel
                </x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
