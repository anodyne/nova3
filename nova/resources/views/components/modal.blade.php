@props([
    'color' => 'success',
    'content' => false,
    'event' => 'modal-load',
    'icon' => false,
    'title',
    'url' => false,
    'wide' => false,
    'width' => 'lg',
])

@push('modal')
    <div
        x-data="modal('{{ $event }}', '{{ $url }}', '{{ csrf_token() }}')"
        x-show="open"
        x-on:modal-close.window="open = false"
        class="fixed inset-x-0 bottom-0 z-50 px-4 pb-6 sm:inset-0 sm:flex sm:items-center sm:justify-center sm:p-0"
    >
        <div
            x-show="open"
            x-on:click="open = false"
            x-description="Background overlay, show/hide based on modal state."
            x-transition:enter="duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
            x-cloak
        >
            <div class="absolute inset-0 z-20 bg-black/25 backdrop-blur-sm"></div>
        </div>

        <div
            x-show="open"
            x-trap.inert.noscroll="open"
            x-description="Modal panel, show/hide based on modal state."
            x-transition:enter="duration-300 ease-out"
            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave="duration-200 ease-in"
            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
            class="sm:max-w-{{ $width }} relative z-[999] overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-950/5 transition-all dark:bg-gray-800 dark:shadow-none dark:highlight-white/5 sm:w-full"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-title"
            x-cloak
        >
            <x-content-box>
                <div class="flex flex-col items-start space-y-4">
                    @if ($icon)
                        <div class="flex shrink-0 items-center justify-center">
                            <x-badge :color="$color" size="circle" icon>
                                <x-icon :name="$icon" size="md"></x-icon>
                            </x-badge>
                        </div>
                    @endif

                    <div class="w-full text-left">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                            {{ $title }}
                        </h3>
                        <div class="mt-2 text-gray-600 dark:text-gray-400">
                            <div x-html="content"></div>
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </x-content-box>

            <x-content-box class="z-20 space-y-4 sm:flex sm:space-x-4 sm:space-y-0" height="sm">
                {{ $footer }}
            </x-content-box>
        </div>
    </div>
@endpush
