<div>
    <select wire:model="departmentId" class="form-select w-full">
        <option value="">Select a department</option>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
        @endforeach
    </select>

    @if (isset($departmentId) && $positions->count() === 0)
        <div class="text-danger-600 font-medium mt-2">No positions available in the department</div>
    @else
        <select wire:model="positionId" class="form-select w-full mt-2" @if ($departmentId === null) disabled @endif>
            <option value="">Select a position</option>
            @isset($positions)
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                @endforeach
            @endisset
        </select>
    @endif
</div>
