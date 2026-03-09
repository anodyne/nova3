<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <x-input.date x-model="state" :icon="$getPrefixIcon()" />
    </div>
</x-dynamic-component>
