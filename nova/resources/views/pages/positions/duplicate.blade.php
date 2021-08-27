<x-form :action="route('positions.duplicate', $position)" id="form-duplicate" :divide="false">
    <div class="text-left space-y-8">
        <x-input.group label="Name" for="name">
            <x-input.text name="name" id="name" placeholder="New position name" />
        </x-input.group>

        <x-input.group label="Department" for="department_id">
            <x-input.select name="department_id" id="department_id" class="w-full">
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"{{ $department->id === $position->department_id ? ' selected' : '' }}>{{ $department->name }}</option>
                @endforeach
            </x-input.select>
        </x-input.group>
    </div>
</x-form>
