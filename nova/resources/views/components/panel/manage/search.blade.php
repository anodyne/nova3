@props([
    'search' => null,
    'models' => [],
    'modelKey' => 'id',
    'modelTitle' => 'name',
    'placeholder' => 'Search...',
])

<x-spacing size="3xs" class="relative">
    <x-select wire:model.live.debounce="selected" variant="combobox" :$placeholder clearable>
        @foreach ($models as $model)
            <x-select.option :value="$model->{$modelKey}">{{ $model->{$modelTitle} }}</x-select.option>
        @endforeach
    </x-select>
</x-spacing>
