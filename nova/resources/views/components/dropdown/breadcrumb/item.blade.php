@props([
    'selected' => false,
])

<button
    type="button"
    class="group flex w-full items-center justify-between gap-x-6 rounded-[calc(var(--radius-xl)-(--spacing(1)))] px-2 py-2 text-left font-medium text-white focus:bg-white/10 focus:text-white focus:outline-hidden"
    {{ $attributes }}
>
    {{ $slot }}

    @if ($selected)
        <div class="shrink-0">
            <x-icon.micro.check class="text-primary-500"></x-icon.micro.check>
        </div>
    @endif
</button>
