<x-field>
    <x-label>Public site theme</x-label>

    <div class="flex items-center gap-2" data-slot="control">
        <x-select name="theme" wire:model.live="selected">
            @foreach ($availableThemes as $theme)
                <option value="{{ $theme->location }}">
                    {{ $theme->name }}
                </option>
            @endforeach
        </x-select>

        <div class="flex shrink-0 items-center">
            <x-button
                wire:click="$dispatch('slide-over.open', {component: 'theme-settings', arguments: {'theme': '{{ $selectedTheme->location }}'}})"
                variant="subtle"
                square
            >
                <span class="shrink-0">
                    <x-icon :name="Tabler::Settings" size="md" />
                </span>
            </x-button>
        </div>
    </div>
</x-field>
