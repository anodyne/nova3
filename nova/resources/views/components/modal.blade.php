@props([
    'color' => 'green',
    'content' => false,
    'event' => 'modal-load',
    'icon' => false,
    'title',
    'url' => false,
    'wide' => false,
])

@push('modal')
    <div
        x-data="modal('{{ $event }}', '{{ $url }}')"
        x-init="listen()"
        x-show="open"
        x-on:keydown.window.escape="open = false"
        x-on:modal-close.window="open = false"
        class="fixed bottom-0 inset-x-0 px-4 pb-6 z-50 | sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center"
    >
        <div
            x-show="open"
            x-on:click="open = false"
            x-description="Background overlay, show/hide based on modal state."
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity z-99"
            x-cloak
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            x-show="open"
            x-description="Modal panel, show/hide based on modal state."
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all z-999 | sm:w-full sm:p-6 @if ($wide) sm:max-w-lg @else sm:max-w-sm @endif"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-title"
            x-cloak
        >
            <div>
                @if ($icon)
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-{{ $color }}-100">
                        @icon($icon, "h-6 w-6 text-{$color}-600")
                    </div>
                @endif

                <div class="mt-3 text-center | sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $title }}
                    </h3>

                    <div class="mt-2 text-gray-500 leading-6" x-html="content"></div>
                </div>
            </div>
            <div class="mt-5 | sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                {{ $footer }}
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        function modal(eventName, url)
        {
            return {
                content: null,
                isLoading: false,
                open: false,
                url: url,

                listen () {
                    window.addEventListener(eventName, (event) => {
                        this.loadModalContent(event.detail);
                    });
                },

                loadModalContent (detail) {
                    fetch(this.url, {
                        method: 'POST',
                        body: JSON.stringify(detail),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.text())
                        .then(data => this.content = data)
                        .finally(() => this.open = true);
                }
            };
        }
    </script>
@endpush
