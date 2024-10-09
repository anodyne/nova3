<div
    class="relative z-10"
    role="dialog"
    aria-modal="true"
    x-data="{ open: false }"
    x-on:toggle-search.window="open = true"
    x-on:keyup.esc="open = false"
    x-trap.inert.noscroll="open"
    x-cloak
>
    <div
        x-show="open"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        aria-hidden="true"
    >
        <div class="fixed inset-0 bg-gray-500/50 transition-opacity"></div>
    </div>

    <div
        class="fixed inset-0 z-10 w-screen overflow-y-auto p-4 transition-all sm:p-6 md:p-20"
        x-show="open"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
    >
        <div
            class="mx-auto max-w-2xl transform rounded-xl bg-gray-950/[.04] p-1.5 shadow-2xl ring-1 ring-inset ring-gray-950/5 backdrop-blur"
            x-on:click.outside="open = false"
        >
            <div class="overflow-hidden rounded-lg bg-white shadow ring-1 ring-gray-950/5 transition-all">
                <div class="relative">
                    <svg
                        class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                        data-slot="icon"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <input
                        type="text"
                        class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                        placeholder="Search..."
                        wire:model.live="search"
                        role="combobox"
                        aria-expanded="false"
                        aria-controls="options"
                        autofocus
                        x-ref="search"
                    />
                </div>

                <!-- Default state, show/hide based on command palette state -->
                <div class="hidden border-t border-gray-950/5 px-6 py-14 text-center text-sm sm:px-14">
                    <svg
                        class="mx-auto h-6 w-6 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true"
                        data-slot="icon"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64"
                        />
                    </svg>
                    <p class="mt-4 font-semibold text-gray-900">Search for clients and projects</p>
                    <p class="mt-2 text-gray-500">Quickly access clients and projects by running a global search.</p>
                </div>

                @if (filled($search))
                    @if ($numberOfResults > 0)
                        <!-- Results, show/hide based on command palette state -->
                        <ul
                            class="max-h-96 scroll-pb-2 scroll-pt-11 space-y-2 overflow-y-auto pb-2"
                            id="options"
                            role="listbox"
                        >
                            @foreach ($results as $model => $modelResults)
                                @if ($modelResults->count() > 0)
                                    <li>
                                        <h2
                                            class="flex items-center justify-between bg-gray-100 px-4 py-2.5 text-xs font-semibold text-gray-900"
                                        >
                                            <span>
                                                {{ $model }}
                                            </span>
                                            <span class="font-normal text-gray-600">
                                                {{ str('result')->plural($modelResults->count())->prepend($modelResults->count().' ') }}
                                            </span>
                                        </h2>
                                        <ul class="mt-2 text-sm text-gray-800">
                                            @foreach ($modelResults as $result)
                                                @includeWhen($model === 'Announcements', 'livewire.search.announcements', ['result' => $result])
                                                @includeWhen($model === 'Characters', 'livewire.search.characters', ['result' => $result])
                                                @includeWhen($model === 'Stories', 'livewire.search.stories', ['result' => $result])
                                                @includeWhen($model === 'Story posts', 'livewire.search.story-posts', ['result' => $result])
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <!-- Empty state, show/hide based on command palette state -->
                        <div class="border-t border-gray-100 px-6 py-14 text-center text-sm sm:px-14">
                            <svg
                                class="mx-auto h-6 w-6 text-gray-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z"
                                />
                            </svg>
                            <p class="mt-4 font-semibold text-gray-900">No results found</p>
                            <p class="mt-2 text-gray-500">
                                We couldn’t find anything with that term. Please try again.
                            </p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
