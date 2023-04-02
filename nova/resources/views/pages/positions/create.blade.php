@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new position">
            <x-slot:actions>
                @can('viewAny', Nova\Departments\Models\Position::class)
                    @if ($selectedDepartment)
                        <x-link :href="route('positions.index', 'department='.$selectedDepartment?->id)" leading="arrow-left" size="none" color="gray-text">
                            Back to {{ $selectedDepartment->name }} positions list
                        </x-link>
                    @else
                        <x-link :href="route('positions.index')" leading="arrow-left" size="none" color="gray-text">
                            Back to positions list
                        </x-link>
                    @endif
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('positions.store')">
            <x-form.section title="Position Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Department" for="department_id" :error="$errors->first('department_id')">
                    <x-input.select name="department_id" id="department_id" class="w-full sm:w-2/3">
                        <option value="">Select a department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected($department->id === $selectedDepartment?->id)>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">{{ old('description') }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Availability">
                <x-slot:message>
                    <p>You can allow or prevent prospective players from picking this position when applying to join by setting the number of available slots.</p>

                    <p class="block"><strong class="font-semibold">Note:</strong> After setting this number, Nova will keep the number updated for you as characters are assigned and un-assigned to this position.</p>
                </x-slot:message>

                <x-input.group label="Available Slots" for="available">
                    <div class="w-full sm:w-1/3">
                        <x-input.number id="available" name="available" :value="old('available', 0)" />
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button-filled type="submit">Add position</x-button-filled>
                <x-link :href="route('positions.index', 'department='.$selectedDepartment?->id)" color="gray">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
