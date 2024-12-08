<ul role="list" class="space-y-6" x-data>
    @foreach ($versionHistory as $version)
        <li class="relative flex gap-x-4">
            <div
                @class([
                    'absolute left-0 top-0 flex w-14 justify-center',
                    '-bottom-6' => ! $loop->last,
                ])
            >
                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
            </div>
            <div class="relative flex h-6 w-14 flex-none items-center justify-center bg-white dark:bg-gray-800">
                @if (str($version->version)->endsWith('.0'))
                    <div
                        class="rounded-full bg-gray-950 px-2.5 text-xs/6 font-medium text-white dark:bg-white dark:text-gray-950"
                    >
                        v{{ $version->series }}
                    </div>
                @else
                    @if ($loop->first || $loop->last)
                        <div
                            class="rounded-full bg-gray-100 px-2.5 text-xs/6 font-medium text-gray-600 ring-1 ring-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:ring-gray-500"
                        >
                            v{{ $version->version }}
                        </div>
                    @else
                        <div
                            class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-700 dark:ring-gray-500"
                            x-tooltip.raw="v{{ $version->version }}"
                        ></div>
                    @endif
                @endif
            </div>
            <div class="flex-auto space-y-2 py-0.5">
                <div class="prose prose-sm dark:prose-invert">
                    {!! str($version->description)->markdown() !!}
                </div>

                <div class="flex gap-2">
                    @if (version_compare($version->version, $filesVersion, '==') && version_compare($version->version, $databaseVersion, '=='))
                        <x-badge size="sm" color="primary">Your installed version</x-badge>
                    @else
                        @if (version_compare($version->version, $filesVersion, '=='))
                            <x-badge size="sm" color="success">Your files version</x-badge>
                        @endif

                        @if (version_compare($version->version, $databaseVersion, '=='))
                            <x-badge size="sm" color="info">Your database version</x-badge>
                        @endif
                    @endif

                    @foreach ($version->tags as $tag)
                        <x-badge size="sm">{{ str($tag)->ucfirst() }}</x-badge>
                    @endforeach
                </div>
            </div>
            <time datetime="{{ $version->release_date }}" class="flex-none py-0.5 text-xs/5 text-gray-500">
                {{ $version->release_date->shortRelativeToNowDiffForHumans() }}
            </time>
        </li>
    @endforeach
</ul>
