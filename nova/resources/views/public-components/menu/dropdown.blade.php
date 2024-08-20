@props(['item'])

<li x-data="{ open: false }" class="relative" x-on:mouseenter="open = true" x-on:mouseleave="open = false">
    <a
        href="{{ $item->link }}"
        target="{{ $item->target }}"
        class="inline-flex items-center gap-x-1"
        aria-expanded="false"
    >
        @if (filled($item->icon))
            <x-icon :name="$item->icon_name"></x-icon>
        @endif

        <span>{{ $item->label }}</span>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path
                fill-rule="evenodd"
                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd"
            />
        </svg>
    </a>

    <div
        class="absolute left-1/2 top-full min-w-[240px] origin-top-right -translate-x-1/2 pt-2"
        x-show="open"
        x-transition:enter="transform transition duration-200 ease-out"
        x-transition:enter-start="-translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-200 ease-out"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
    >
        <div class="rounded-lg bg-white p-4 shadow-xl ring-1 ring-gray-900/5 [&[x-cloak]]:hidden">
            <div class="shrink space-y-3 text-sm/6 font-semibold text-gray-900">
                @foreach ($item->items as $subItem)
                    <x-public::menu.link :item="$subItem"></x-public::menu.link>
                @endforeach
            </div>
        </div>
    </div>
</li>
