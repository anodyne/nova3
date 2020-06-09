<div
    x-cloak
    x-data="{ show: false, title: '', message: '' }"
    x-on:toast.window="show = true; title = $event.detail.title; message = $event.detail.message; setTimeout(() => { show = false }, 5000)"
    x-show="show"
    x-description="Notification panel, show/hide based on alert state."
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto"
>
    <div class="rounded-lg shadow-xs overflow-hidden">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @icon('check-alt', 'h-5 w-5 text-green-500')
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p x-text="title" class="text-sm leading-5 font-medium text-gray-900"></p>
                    <p x-text="message" class="mt-1 text-sm leading-5 text-gray-500"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button x-on:click="show = false" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
