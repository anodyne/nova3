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
        @modal-close.window="open = false"
        class="fixed bottom-0 inset-x-0 px-4 pb-6 z-50 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center"
    >
        <div
            x-show="open"
            @click="open = false"
            x-description="Background overlay, show/hide based on modal state."
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
            x-cloak
        >
            <div class="absolute inset-0 bg-black/25 backdrop-blur-sm z-20"></div>
        </div>

        <div
            x-show="open"
            x-trap.inert.noscroll="open"
            x-description="Modal panel, show/hide based on modal state."
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white dark:bg-gray-800 dark:shadow-none dark:highlight-white/5 ring-1 ring-gray-900/[.02] rounded-lg overflow-hidden shadow-xl transition-all z-[999] sm:w-full sm:max-w-{{ $width }} ring-1 ring-gray-900/5"
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

            <x-content-box class="z-20 sm:flex space-y-4 sm:space-y-0 sm:space-x-4" height="sm">
                {{ $footer }}
            </x-content-box>
        </div>
    </div>
@endpush
