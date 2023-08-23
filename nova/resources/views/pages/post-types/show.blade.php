@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden">
        <x-panel.header :message="str($postType->visibility)->replace('-', ' ')->title()">
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $postType->name }}</span>
                    <div class="flex items-center">
                        <x-badge :color="$postType->status->color()">
                            {{ $postType->status->getLabel() }}
                        </x-badge>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $postType)
                    <x-button.text :href="route('post-types.index')" color="gray" leading="arrow-left">
                        Back
                    </x-button.text>
                @endcan

                @can('update', $postType)
                    <x-button.filled :href="route('post-types.edit', $postType)" color="primary" leading="edit">
                        Edit
                    </x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <div class="flex flex-col divide-gray-200 lg:flex-row lg:divide-x">
            <div class="flex flex-1 flex-col justify-between gap-6 divide-y divide-gray-200">
                @if (filled($postType->description))
                    <x-content-box>
                        <p class="max-w-xl text-lg">{{ $postType->description }}</p>
                    </x-content-box>
                @endif

                <x-content-box>
                    <div class="grid grid-cols-1 gap-px bg-white/5 lg:grid-cols-3">
                        <div class="px-4 sm:px-6">
                            <p class="text-sm font-medium leading-6">Total posts</p>
                            <p class="mt-2 flex items-baseline gap-x-2">
                                <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    {{ $postType->published_posts_count }}
                                </span>
                            </p>
                        </div>
                        <div class="px-4 sm:px-6">
                            <p class="text-sm font-medium leading-6">Icon</p>
                            <p class="mt-2 flex items-baseline gap-x-2">
                                @if (filled($postType->icon))
                                    <x-icon :name="$postType->icon" size="h-11 w-11 md:h-10 md:w-10"></x-icon>
                                @else
                                    <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        &ndash;
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="px-4 sm:px-6">
                            <p class="text-sm font-medium leading-6">Accent color</p>
                            <p class="mt-2 flex items-baseline gap-x-2">
                                <div
                                    class="flex items-center gap-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white"
                                >
                                    <span style="color: {{ $postType->color }}">{{ $postType->color }}</span>
                                </div>
                            </p>
                        </div>
                    </div>
                </x-content-box>
            </div>

            <div class="w-full divide-y divide-gray-200 lg:w-1/3">
                <div class="flex w-full flex-col">
                    <div class="flex items-center justify-between px-4 py-4">
                        <x-h3>Fields</x-h3>
                    </div>

                    <div>
                        @foreach ($fieldTypes as $fieldType)
                            @if ($postType->fields->{$fieldType}->enabled)
                                <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                    <div class="flex items-center">
                                        <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                    </div>

                                    <span>{{ str($fieldType)->title() }} field</span>

                                    @if ($postType->fields->{$fieldType}->required)
                                        <span class="text-sm">(required)</span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="flex w-full flex-col">
                    <div class="flex items-center justify-between px-4 py-4">
                        <x-h3>Options</x-h3>
                    </div>

                    <div class="font-medium">
                        @if ($postType->options->notifiesUsers)
                            <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>Sends notifications when published</span>
                            </div>
                        @endif

                        @if ($postType->options->includedInPostTracking)
                            <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>Included in activity tracking stats</span>
                            </div>
                        @endif

                        @if ($postType->options->allowsMultipleAuthors)
                            <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>Allows multiple authors</span>
                            </div>
                        @endif

                        @if ($postType->options->allowsCharacterAuthors)
                            <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>Allows characters as authors</span>
                            </div>
                        @endif

                        @if ($postType->options->allowsUserAuthors)
                            <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>Allows users as authors</span>
                            </div>
                        @endif

                        @if ($postType->role)
                            <div class="flex items-center gap-3 px-4 py-4 odd:bg-gray-100 dark:odd:bg-gray-700/50 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>Requires {{ $postType->role->display_name }} role</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-panel>
@endsection
