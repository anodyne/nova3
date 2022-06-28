<div class="flex items-center space-x-3">
    <x-input.select name="{{ $name }}" wire:model="selected">
        <option value="">Choose a color</option>
        @foreach ($colors as $color => $name)
            <option value="{{ $color }}">{{ $name }}</option>
        @endforeach
    </x-input.select>

    <div class="shrink-0">
        <div class="bg-preview-{{ $selected }} h-8 w-8 rounded-full"></div>
    </div>
</div>
