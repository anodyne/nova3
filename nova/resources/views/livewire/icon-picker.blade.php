<flux:select
    variant="listbox"
    placeholder="Choose an icon"
    wire:model="selected"
    data-slot="control"
    :name="$field"
    clearable
    searchable
>
    @foreach (Icon::cases() as $icon)
        <flux:select.option :value="$icon->value">
            <div class="flex items-center gap-3">
                <x-icon :name="$icon" size="md" class="shrink-0"></x-icon>
                {{ $icon->getLabel() }}
            </div>
        </flux:select.option>
    @endforeach
</flux:select>
