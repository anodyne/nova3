@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit position">
            <x-slot:actions>
                @can('viewAny', Nova\Departments\Models\Position::class)
                    <x-link :href="route('positions.index', 'department='.$position->department->id)" leading="arrow-left" size="none" color="gray-text">
                        Back to {{ $position->department->name }} positions
                    </x-link>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('positions.update', $position)" method="PUT">
            <x-form.section title="Position Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $position->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Department" for="department_id" :error="$errors->first('department_id')">
                    <x-input.select name="department_id" id="department_id" class="w-full sm:w-2/3">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @if ($department->id == old('department_id', $position->department->id)) selected @endif>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">{{ old('description', $position->description) }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="status"
                        :value="old('status', $position->status ?? 'active')"
                        active-value="active"
                        inactive-value="inactive"
                    >
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Availability">
                <x-slot:message>
                    You can allow or prevent prospective players from picking this position when applying to join by setting the number of available slots.

                    <p class="block"><strong class="font-semibold">Note:</strong> after setting this number, Nova will manage keep the number updated for you as characters are assigned and un-assigned to this position.</p>
                </x-slot:message>

                <x-input.group label="Available Slots" for="available">
                    <div class="w-full sm:w-1/3">
                        <x-input.number id="available" name="available" :value="old('available', $position->available)" />
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button-filled type="submit">Save position</x-button-filled>
                <x-link :href="route('positions.index', $position->department)" color="gray">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
