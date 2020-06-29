<div>
    <select wire:model="groupId" class="form-select w-full">
        <option value="">Select a rank group</option>
        @foreach ($groups as $group)
            <option value="{{ $group->id }}">{{ $group->name }}</option>
        @endforeach
    </select>

    @if (isset($groupId) && $ranks->count() === 0)
        <div class="text-danger-600 font-medium mt-2">No ranks available in this group</div>
    @else
        <select wire:model="rankId" class="form-select w-full mt-2" @if ($groupId === null) disabled @endif>
            <option value="">Select a rank</option>
            @isset($ranks)
                @foreach ($ranks as $rank)
                    <option value="{{ $rank->id }}">{{ $rank->name->name }}</option>
                @endforeach
            @endisset
        </select>
    @endif

    @isset ($selectedRank)
        <div class="mt-4">
            <x-rank :rank="$selectedRank" />
        </div>
    @endisset
</div>
