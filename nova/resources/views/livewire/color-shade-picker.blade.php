<div>
    <div class="flex items-center space-x-3">
        @if (str($selected)->startsWith('#'))
            <x-input.text name="{{ $name }}" wire:model.debounce.500ms="selected">
                <x-slot:trailingAddOn>
                    <button type="button" wire:click="resetField">
                        @icon('close', 'h-5 w-5')
                    </button>
                </x-slot:trailingAddOn>
            </x-input.text>
        @else
            <x-input.select name="{{ $name }}" wire:model="selected">
                <option value="">Choose a color</option>
                @foreach ($colors as $color => $name)
                    <option value="{{ $color }}" @selected($color === $selected)>{{ $name }}</option>
                @endforeach
            </x-input.select>
        @endif

        <div class="shrink-0">
            <div class="h-8 w-8 rounded-full" style="background-color:{{ $this->previewColor }}"></div>
        </div>
    </div>
</div>
