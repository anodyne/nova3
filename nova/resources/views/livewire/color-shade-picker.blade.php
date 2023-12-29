<div>
    <div class="flex items-center gap-3">
        @if (str($selected)->startsWith('#'))
            <x-input.text name="{{ $name }}" wire:model.live.debounce.500ms="selected">
                <x-slot name="trailing">
                    <button type="button" wire:click="resetField">
                        <x-icon name="x" size="sm"></x-icon>
                    </button>
                </x-slot>
            </x-input.text>
        @else
            <x-input.select name="{{ $name }}" wire:model.live="selected">
                <option value="">Choose a color</option>
                @foreach ($colors as $color => $name)
                    <option value="{{ $color }}" @selected($color === $selected)>{{ $name }}</option>
                @endforeach
            </x-input.select>
        @endif

        <div class="shrink-0">
            <div class="h-8 w-8 rounded-full" style="background-color: {{ $previewColor }}"></div>
        </div>
    </div>

    @if ($allowPanda)
        <div class="ml-0.5 mt-2 flex items-center gap-x-2.5">
            <x-switch wire:model.live="panda" id="panda" name="panda" :on-value="1" :off-value="0"></x-switch>
            <x-fieldset.label for="panda">Pandify 🐼</x-fieldset.label>
        </div>
    @endif
</div>
