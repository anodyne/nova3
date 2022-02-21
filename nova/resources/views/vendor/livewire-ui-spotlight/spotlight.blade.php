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
            x-trap.noscroll="isOpen"
            class="relative transition-all max-w-xl w-full"
        >
            <div class="mx-auto max-w-xl transform divide-y divide-gray-6 overflow-hidden rounded-xl bg-gray-1 dark:bg-gray-3 shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                <div class="relative flex items-center space-x-3 px-4 py-4">
                    <div class="shrink-0">
                        @icon('arrow-right', 'h-6 w-6 text-gray-9')
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
                        class="appearance-none w-full bg-transparent text-gray-12 p-0 text-lg placeholder-gray-9 focus:border-0 focus:ring-0 focus:border-transparent focus:shadow-none outline-none focus:outline-none"
                        x-bind:placeholder="inputPlaceholder"
                    >
                    <div class="shrink-0">
                        <svg class="animate-spin h-6 w-6 text-gray-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.delay><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                </div>

                <ul x-ref="results" x-show="filteredItems().length > 0" class="max-h-80 space-y-1.5 overflow-y-auto px-4 pt-2 pb-4" style="scroll-padding-top: 2.5rem; scroll-padding-bottom: 0.5rem" role="listbox">
                    <template x-for="(item, i) in filteredItems()" :key>
                        <li>
                            <button
                                @click="go(item[0].item.id)"
                                class="group block w-full px-4 py-2 text-left rounded-lg"
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

                <div x-show="input === ''" class="flex flex-col space-y-4 py-14 px-6 text-center text-base sm:px-14">
                    @icon('lightbulb', 'mx-auto h-8 w-8 text-gray-9')
                    <p class="text-lg font-semibold text-gray-12">Move around Nova at warp speed</p>
                    <ul class="text-gray-11 space-y-4">
                        <li>Start typing any resource like <span class="text-blue-11 font-medium">story</span> or <span class="text-blue-11 font-medium">character</span> to see available actions you can take</li>
                        <li>Start typing an action like <span class="text-blue-11 font-medium">create</span> or <span class="text-blue-11 font-medium">view</span> to see available actions you can take on resources</li>
                        <li>Not sure where to find a setting? Start typing what setting you want to change.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
