{{-- <div>
    <aside class="pb-8 px-4 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3 xl:col-span-2">
        <nav class="flex mt-1" aria-label="Progress">
            <ol role="list" class="space-y-6">
                @foreach ($steps as $step)
                    <li>
                        <a
                            @if ($step->isPrevious())
                                role="button"
                                wire:click="{{ $step->show() }}"
                            @endif
                            class="group transition"
                        >
                            <div class="flex items-start space-x-3">
                                @if ($step->isPrevious())
                                    <span class="shrink-0 relative h-5 w-5 flex items-center justify-center">
                                        <!-- Heroicon name: solid/check-circle -->
                                        <svg class="h-full w-full text-primary-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif

                                @if ($step->isCurrent())
                                    <span class="shrink-0 h-5 w-5 relative flex items-center justify-center" aria-hidden="true">
                                        <span class="absolute h-4 w-4 rounded-full bg-primary-200 dark:bg-primary-900"></span>
                                        <span class="relative block w-2 h-2 bg-primary-500 rounded-full"></span>
                                    </span>
                                @endif

                                @if ($step->isNext())
                                    <div class="shrink-0 h-5 w-5 relative flex items-center justify-center" aria-hidden="true">
                                        <div @class([
                                            'h-2 w-2 bg-gray-400 dark:bg-gray-600 rounded-full',
                                            'group-hover:bg-gray-400' => $step->isPrevious(),
                                        ])></div>
                                    </div>
                                @endif

                                <span @class([
                                    'text-sm font-medium',
                                    'text-gray-500' => $step->isNext() || $step->isPrevious(),
                                    'text-primary-600 dark:text-primary-500' => $step->isCurrent(),
                                    'group-hover:text-gray-700 dark:group-hover:text-gray-400' => $step->isPrevious(),
                                ])>{{ $step->label }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>
    </aside>

    <div class="space-y-6 sm:px-6 lg:px-0">
        {{ $slot }}
    </div>
</div> --}}

<x-panel>
    <x-content-box>
        <nav aria-label="Progress">
            <ol role="list" class="space-y-4 md:flex md:space-y-0 md:space-x-8">
                @foreach ($steps as $step)
                    <li class="md:flex-1">
                        <a
                            @if ($step->isPrevious())
                                role="button"
                                wire:click="{{ $step->show() }}"
                            @endif

                            @class([
                                'group flex flex-col',
                                'border-l-4 pl-4 py-2 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4' => false,
                                'border-primary-500 hover:border-primary-600 dark:hover:border-primary-400' => $step->isPrevious(),
                                'border-primary-500' => $step->isCurrent(),
                                'border-gray-300 dark:border-gray-600' => $step->isNext(),
                            ])
                        >
                            <div @class([
                                'h-1.5 w-full rounded-full mb-4',
                                'bg-primary-500 hover:bg-primary-600 dark:hover:bg-primary-400' => $step->isPrevious(),
                                'bg-primary-500' => $step->isCurrent(),
                                'bg-gray-300 dark:bg-gray-600' => $step->isNext(),
                            ])></div>

                            <span
                                @class([
                                    'text-xs font-semibold tracking-wide uppercase',
                                    'text-primary-600 dark:text-primary-500 group-hover:text-primary-600 dark:group-hover:text-primary-500' => $step->isPrevious(),
                                    'text-primary-600 dark:text-primary-500' => $step->isCurrent(),
                                    'text-gray-600 dark:text-gray-500' => $step->isNext(),
                                ])
                            >Step {{ $loop->iteration }}</span>
                            <span class="text-sm font-medium">{{ $step->label }}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>

        {{-- <nav aria-label="Progress">
            <ol role="list" class="flex items-center">
                @foreach ($steps as $step)
                    <li @class([
                        'relative',
                        'pr-8 sm:pr-20' => ! $loop->last
                    ])>
                        @if ($step->isPrevious())
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-primary-600"></div>
                            </div>
                        @endif

                        @if ($step->isCurrent())
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-gray-200"></div>
                            </div>
                        @endif

                        @if ($step->isNext())
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-gray-200"></div>
                            </div>
                        @endif

                        <a
                            href="#"
                            @class([
                                'relative h-8 w-8 flex items-center justify-center rounded-full',
                                'bg-primary-600 hover:bg-primary-900' => $step->isPrevious(),
                                'bg-white border-2 border-primary-600' => $step->isCurrent(),
                                'bg-white border-2 border-gray-300 hover:border-gray-400' => $step->isNext(),
                            ])
                        >
                            @if ($step->isPrevious())
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif

                            @if ($step->isCurrent())
                                <span class="h-2.5 w-2.5 bg-primary-600 rounded-full" aria-hidden="true"></span>
                            @endif

                            @if ($step->isNext())
                                <span class="h-2.5 w-2.5 bg-transparent rounded-full group-hover:bg-gray-300" aria-hidden="true"></span>
                            @endif

                            <span class="sr-only">Step {{ $loop->iteration }}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav> --}}
    </x-content-box>

    <div class="space-y-6 sm:px-6 lg:px-0">
        {{ $slot }}
    </div>
</x-panel>