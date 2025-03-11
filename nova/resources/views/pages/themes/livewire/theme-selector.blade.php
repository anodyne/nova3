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
            <x-button
                wire:click="$dispatch('slide-over.open', {component: 'theme-settings', arguments: {'theme': '{{ $selectedTheme->location }}'}})"
                text
            >
                <span class="shrink-0">
                    <x-icon name="settings" size="md"></x-icon>
                </span>
            </x-button>
        </div>
    </div>
</x-fieldset.field>
