@props([
    'selected' => false,
])

<button
    type="button"
    class="flex w-full items-center justify-between gap-x-6 rounded-md px-2 py-1 text-left hover:bg-gray-950/5"
    x-on:click="open = false"
    {{ $attributes }}
>
    {{ $slot }}

    @if ($selected)
        <div class="shrink-0">
            <x-icon.micro.check class="text-primary-500"></x-icon.micro.check>
        </div>
    @endif
</button>
