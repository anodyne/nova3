<div>
    <x-spacing>
        <x-page-header>
            <x-slot name="heading">Write a story post</x-slot>
            <x-slot name="description">{{ $message }}</x-slot>
        </x-page-header>

        <nav aria-label="Progress">
            <ol role="list" class="space-y-4 md:flex md:space-x-8 md:space-y-0">
                @foreach ($steps as $step)
                    <li class="md:flex-1">
                        <a
                            @if ($step->isPrevious())
                                role="button"
                                wire:click="{{ $step->show() }}"
                            @endif
                            @class([
                                'group flex flex-col',
                                'border-l-4 py-2 pl-4 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4' => false,
                                'border-primary-500 hover:border-primary-600 dark:hover:border-primary-400' => $step->isPrevious(),
                                'border-primary-500' => $step->isCurrent(),
                                'border-gray-300 dark:border-gray-600' => $step->isNext(),
                            ])
                        >
                            <div
                                @class([
                                    'mb-4 h-1.5 w-full rounded-full',
                                    'bg-primary-500 hover:bg-primary-600 dark:hover:bg-primary-400' => $step->isPrevious(),
                                    'bg-primary-500' => $step->isCurrent(),
                                    'bg-gray-300 dark:bg-gray-600' => $step->isNext(),
                                ])
                            ></div>

                            <span
                                @class([
                                    'pl-0.5 text-xs font-medium',
                                    'text-primary-600 group-hover:text-primary-600 dark:text-primary-500 dark:group-hover:text-primary-500' => $step->isPrevious(),
                                    'text-primary-600 dark:text-primary-500' => $step->isCurrent(),
                                    'text-gray-500 dark:text-gray-500' => $step->isNext(),
                                ])
                            >
                                Step {{ $loop->iteration }}
                            </span>
                            <span
                                @class([
                                    'pl-0.5 pt-0.5 text-sm',
                                    'font-medium text-gray-600 dark:text-gray-400' => ! $step->isCurrent(),
                                    'font-semibold text-primary-800 dark:text-primary-100' => $step->isCurrent(),
                                ])
                            >
                                {{ $step->label }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>
    </x-spacing>

    <x-spacing class="mt-8 space-y-12" constrained-lg>
        {{ $slot }}
    </x-spacing>
</div>
