@props([
    'value',
    'text',
])

<button
    type="button"
    class="flex w-full items-center rounded-[calc(var(--radius-xl)-(--spacing(1)))] px-2 py-1.5 text-sm font-medium text-white transition hover:bg-white/10 focus:outline-none"
    wire:click="add('{{ $value }}')"
>
    {{ $text }}
</button>
