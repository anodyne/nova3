<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <x-input.date x-model="state" :icon="$getIcon()"></x-input.date>
    </div>
</x-dynamic-component>
