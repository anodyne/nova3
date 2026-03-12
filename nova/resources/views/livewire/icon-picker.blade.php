<div data-slot="control">
    <x-select variant="listbox" placeholder="Choose an icon" wire:model.live="selected" clearable searchable>
        <x-slot name="search">
            <flux:select.search class="px-4" placeholder="Search for an icon..." wire:model.live.debounce="query" />
        </x-slot>

        @foreach ($filteredIcons as $icon)
            <x-select.option :value="$icon">
                <div class="flex items-center gap-2">
                    @svg($icon, 'size-6 shrink-0')
                    {{ str($icon)->replace('tabler-', '')->headline() }}
                </div>
            </x-select.option>
        @endforeach
    </x-select>

    <input type="hidden" name="{{ $field }}" value="{{ $selected }}" />
</div>
