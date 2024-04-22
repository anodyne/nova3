<x-fieldset.field label="Public site theme" id="theme" name="theme">
    <div class="flex items-center gap-x-3" data-slot="control">
        <x-select class="mt-1 block w-full" wire:model.live="selected">
            @foreach ($availableThemes as $theme)
                <option value="{{ $theme->location }}">
                    {{ $theme->name }}
                </option>
            @endforeach
        </x-select>

        <div class="flex shrink-0 items-center">
            <livewire:theme-settings :theme="$selectedTheme" :key="$selectedTheme->location" />
        </div>
    </div>
</x-fieldset.field>
