@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Position">
        <x-slot name="pretitle">
            <div class="flex items-center">
                <a href="{{ route('departments.index') }}">Departments</a>

                @if ($selectedDepartment)
                    @icon('chevron-right', 'h-4 w-4 text-gray-500 mx-1')
                    <a href="{{ route('positions.index', $selectedDepartment) }}">{{ $selectedDepartment->name }}</a>
                @endif
            </div>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('positions.store')">
            <x-form.section title="Position Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Department" for="department_id" :error="$errors->first('department_id')">
                    <select name="department_id" id="department_id" class="form-select w-full | sm:w-2/3">
                        <option value="">Select a department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @if ($department->id == optional($selectedDepartment)->id) selected @endif>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="5">{{ old('description') }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Availability">
                <x-slot name="message">
                    You can allow or prevent prospective players from picking this position when applying to join by setting the number of available slots.

                    <p class="block mt-6"><strong class="font-semibold">Note:</strong> after setting this number, Nova will manage keep the number updated for you as characters are assigned and un-assigned to this position.</p>
                </x-slot>

                <x-input.group label="Available Slots" for="available">
                    <div class="w-full | sm:w-1/3">
                        <x-input.number id="available" name="available" :value="old('available', 0)" />
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Position</button>

                @if ($selectedDepartment)
                    <a href="{{ route('positions.index', $selectedDepartment) }}" class="button">Cancel</a>
                @else
                    <a href="{{ route('departments.index') }}" class="button">Cancel</a>
                @endif
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
