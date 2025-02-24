@props([
    'trigger' => null,
    'placeholder' => null,
])

<div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
    @if ($trigger?->isNotEmpty())
        <button
            type="button"
            class="flex items-center gap-x-2 rounded-lg px-2.5 py-1 hover:bg-gray-950/5"
            x-bind:class="{
                'bg-gray-950/5': open,
            }"
            x-on:click="open = !open"
        >
            {{ $trigger }}
            <x-icon.micro.chevron-up-down class="text-gray-400 dark:text-gray-600" />
        </button>
    @endif

    @if ($placeholder?->isNotEmpty())
        <div class="px-2.5 py-1">
            {{ $placeholder }}
        </div>
    @endif

    <div
        class="absolute isolate mt-1.5 w-screen max-w-[14rem] origin-top-left transform rounded-lg bg-white px-1 py-1 shadow-lg ring-1 ring-gray-950/5 transition dark:bg-gray-800 dark:ring-white/20"
        x-show="open"
        x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0"
        x-cloak
    >
        {{ $slot }}
    </div>
</div>
