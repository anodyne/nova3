<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div
        x-data="LivewireUISpotlight({ componentId: '{{ $this->id }}', placeholder: '{{ trans('livewire-ui-spotlight::spotlight.placeholder') }}', commands: {{ $commands }} })"
        x-init="init()"
        x-show="isOpen"
        x-cloak
        @foreach(config('livewire-ui-spotlight.shortcuts') as $key)
            @keydown.window.prevent.cmd.{{ $key }}="toggleOpen()"
            @keydown.window.prevent.ctrl.{{ $key }}="toggleOpen()"
        @endforeach
        @keydown.window.escape="isOpen = false"
        @toggle-spotlight.window="toggleOpen()"
        class="fixed z-50 px-4 pt-16 flex items-start justify-center inset-0 sm:pt-24"
    >
        <div
            x-show="isOpen"
            @click="isOpen = false"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
        >
            <div class="absolute inset-0 bg-black opacity-[65%]"></div>
        </div>

        <div
            x-show="isOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative transform transition-all max-w-lg w-full"
        >
            <div class="bg-white rounded-lg overflow-hidden shadow-xl">
                <div class="relative">
                    <div class="absolute h-full right-5 flex items-center">
                        <svg class="animate-spin h-5 w-5 text-gray-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.delay><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                    <input
                        @keydown.tab.prevent=""
                        @keydown.prevent.stop.enter="go()"
                        @keydown.prevent.arrow-up="selectUp()"
                        @keydown.prevent.arrow-down="selectDown()"
                        x-ref="input"
                        x-model="input"
                        type="text"
                        style="caret-color: #6b7280; border: 0 !important;"
                        class="appearance-none w-full bg-transparent px-6 py-4 text-gray-12 text-lg placeholder-gray-9 focus:border-0 focus:ring-0 focus:border-transparent focus:shadow-none outline-none focus:outline-none"
                        x-bind:placeholder="inputPlaceholder"
                    >
                </div>
                <div class="border-t border-gray-6" x-show="filteredItems().length > 0" style="display: none;">
                    <ul x-ref="results" style="max-height: 265px;" class="overflow-y-auto">
                        <template x-for="(item, i) in filteredItems()" :key>
                            <li>
                                <button
                                    @click="go(item[0].item.id)"
                                    class="group block w-full px-6 py-3 text-left"
                                    :class="{ 'bg-blue-3': selected === i, 'hover:bg-blue-3': selected !== i }"
                                >
                                    <span
                                        x-text="item[0].item.name"
                                        class="font-medium"
                                        :class="{ 'text-gray-12 group-hover:text-blue-12': selected !== i, 'text-blue-12': selected === i }"
                                    ></span>
                                    <span
                                        x-text="item[0].item.description"
                                        class="ml-3 text-base md:text-sm"
                                        :class="{ 'text-gray-9 group-hover:text-blue-9': selected !== i, 'text-blue-9': selected === i }"
                                    ></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="mt-8 bg-white bg-opacity-10 backdrop-filter backdrop-blur rounded-lg overflow-hidden">
                <ul class="text-white font-medium">
                    <li class="block w-full px-6 py-3 text-left">
                        Type <code>POST</code> to search for a specific post
                    </li>
                    <li class="block w-full px-6 py-3 text-left border-t border-white border-opacity-[5%]">
                        Type <code>USER</code> to search for a specific user
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
