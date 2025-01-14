@use('Illuminate\Support\Number')
@use('Nova\Settings\Enums\PostingTimeframe')

<x-admin-layout>
    <x-page-header></x-page-header>

    <!-- xs to lg -->
    <div class="mx-auto mt-12 max-w-md space-y-8 sm:mt-16 lg:hidden">
        <flux:accordion transition>
            @foreach ($timeframes as $key => $timeframeLabel)
                <flux:accordion.item :heading="$timeframeLabel">
                    <flux:accordion.content>
                        <ul role="list" class="space-y-4 text-sm/6 text-gray-900 dark:text-white">
                            @foreach ($stats as $category)
                                <li>
                                    <div class="py-4">
                                        <div class="font-semibold">{{ $category->label }}</div>

                                        @if (filled($category->hint))
                                            <div class="text-gray-600 dark:text-gray-300">
                                                {{ $category->hint }}
                                            </div>
                                        @endif
                                    </div>

                                    <ul role="list">
                                        @foreach ($category->stats as $line)
                                            <li
                                                class="flex items-center justify-between rounded-md px-2 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                                            >
                                                <div class="py-2 text-sm/6 font-medium text-gray-900 dark:text-white">
                                                    {{ $line->label }}
                                                </div>
                                                <div
                                                    class="text-sm/6 font-semibold tabular-nums text-gray-600 dark:text-gray-300"
                                                >
                                                    @if (filled($line->{$key}))
                                                        {{ $line->{$key} }}
                                                    @else
                                                        <svg
                                                            class="mx-auto size-5 text-gray-400 dark:text-gray-500"
                                                            viewBox="0 0 20 20"
                                                            fill="currentColor"
                                                            aria-hidden="true"
                                                            data-slot="icon"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                                clip-rule="evenodd"
                                                            />
                                                        </svg>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </flux:accordion.content>
                </flux:accordion.item>
            @endforeach
        </flux:accordion>
    </div>

    <!-- lg+ -->
    <div class="isolate mt-20 hidden lg:block">
        <div class="relative -mx-8">
            @if ($settings->isMonthlyTimeframe())
                <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
                    <div class="flex w-1/4 px-4" style="margin-left: 50%" aria-hidden="true">
                        <div
                            class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5 dark:border-white/10 dark:bg-white/5"
                        ></div>
                    </div>
                </div>
            @else
                <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
                    <div class="flex w-1/5 px-4" style="margin-left: 40%" aria-hidden="true">
                        <div
                            class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5 dark:border-white/10 dark:bg-white/5"
                        ></div>
                    </div>
                </div>
                <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
                    <div class="flex w-1/5 px-4" style="margin-left: 80%" aria-hidden="true">
                        <div
                            class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5 dark:border-white/10 dark:bg-white/5"
                        ></div>
                    </div>
                </div>
            @endif

            <table class="w-full table-fixed border-separate border-spacing-x-8 text-left">
                <caption class="sr-only">Game stats</caption>
                <colgroup>
                    <col class="w-1/5" />
                    <col class="w-1/5" />
                    <col class="w-1/5" />
                    <col class="w-1/5" />
                    @unless ($settings->isMonthlyTimeframe())
                        <col class="w-1/5" />
                    @endunless
                </colgroup>
                <thead>
                    <tr>
                        <td></td>
                        @unless ($settings->isMonthlyTimeframe())
                            <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                                <div class="text-center text-base/8 font-semibold text-gray-900 dark:text-white">
                                    {{ $settings->timeframe->getStatsLabel() }}
                                </div>
                            </th>
                        @endunless

                        <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                            <div class="text-center text-base/8 font-semibold text-gray-900 dark:text-white">
                                {{ now()->subMonth()->format('F Y') }}
                            </div>
                        </th>
                        <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                            <div class="text-center text-base/8 font-semibold text-gray-900 dark:text-white">
                                {{ now()->format('F Y') }}
                            </div>
                        </th>
                        <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                            <div class="text-center text-base/8 font-semibold text-gray-900 dark:text-white">
                                Lifetime
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats as $category)
                        <tr>
                            <th
                                scope="colgroup"
                                colspan="{{ ($settings->timeframe === PostingTimeframe::Monthly) ? 4 : 5 }}"
                                @class([
                                    'pb-4 text-sm/6 font-semibold text-gray-900 dark:text-white',
                                    'pt-4' => $loop->first,
                                    'pt-16' => ! $loop->first,
                                ])
                            >
                                <div class="flex items-center gap-x-1.5">
                                    {{ $category->label }}

                                    @if (filled($category->hint))
                                        <div x-tooltip.raw="{{ $category->hint }}">
                                            <x-icon.micro.question-mark-circle
                                                class="size-4 text-gray-400 dark:text-gray-500"
                                            ></x-icon.micro.question-mark-circle>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/10 dark:bg-white/10"></div>
                            </th>
                        </tr>

                        @foreach ($category->stats as $line)
                            <tr>
                                <th scope="row" class="py-4 text-sm/6 font-normal text-gray-900 dark:text-white">
                                    {{ $line->label }}
                                    <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5 dark:bg-white/5"></div>
                                </th>
                                @unless ($settings->isMonthlyTimeframe())
                                    <td class="px-6 py-4 xl:px-8">
                                        <div
                                            class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-300"
                                        >
                                            @if (filled($line->currentTimeframe))
                                                {{ $line->currentTimeframe }}
                                            @else
                                                <svg
                                                    class="mx-auto size-5 text-gray-400 dark:text-gray-500"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                    data-slot="icon"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            @endif
                                        </div>
                                    </td>
                                @endunless

                                <td class="px-6 py-4 xl:px-8">
                                    <div
                                        class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-300"
                                    >
                                        @if (filled($line->lastMonth))
                                            {{ $line->lastMonth }}
                                        @else
                                            <svg
                                                class="mx-auto size-5 text-gray-400 dark:text-gray-500"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 xl:px-8">
                                    <div
                                        class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-300"
                                    >
                                        @if (filled($line->thisMonth))
                                            {{ $line->thisMonth }}
                                        @else
                                            <svg
                                                class="mx-auto size-5 text-gray-400 dark:text-gray-500"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 xl:px-8">
                                    <div
                                        class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-300"
                                    >
                                        @if (filled($line->lifetime))
                                            {{ $line->lifetime }}
                                        @else
                                            <svg
                                                class="mx-auto size-5 text-gray-400 dark:text-gray-500"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
