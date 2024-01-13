<x-write-post-wizard-layout
    :steps="$steps"
    message="Compose your post. You’ll be able to set the content rating, summary, and order within the story before publishing."
>
    <x-spacing>
        <div class="space-y-8">
            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="space-between flex items-center">
                        <input
                            type="text"
                            wire:model.blur="form.title"
                            class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 text-3xl font-extrabold tracking-tight text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-100"
                            placeholder="Add a title"
                        />
                    </div>
                </div>

                @if ($postType->fields->location->enabled || $postType->fields->day->enabled || $postType->fields->time->enabled)
                    <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-4 md:space-y-0">
                        @if ($postType->fields->location->enabled)
                            <div class="flex flex-1 items-center gap-2">
                                <x-icon name="location" size="sm" class="text-gray-500"></x-icon>
                                <input
                                    type="text"
                                    wire:model.blur="form.location"
                                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                                    placeholder="Add a location"
                                />
                            </div>
                        @endif

                        @if ($postType->fields->day->enabled)
                            <div class="flex flex-1 items-center gap-2">
                                <x-icon name="calendar" size="sm" class="text-gray-500"></x-icon>
                                <input
                                    type="text"
                                    wire:model.blur="form.day"
                                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                                    placeholder="Add a day"
                                />
                            </div>
                        @endif

                        @if ($postType->fields->time->enabled)
                            <div class="flex flex-1 items-center gap-2">
                                <x-icon name="clock" size="sm" class="text-gray-500"></x-icon>
                                <input
                                    type="text"
                                    wire:model.blur="form.time"
                                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                                    placeholder="Add a time"
                                />
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <x-editor wire:model.live="form.content"></x-editor>
        </div>
    </x-spacing>

    <x-panel well>
        <x-spacing size="sm">
            <div class="flex items-center justify-between">
                <x-fieldset.legend>{{ $postType->name }} in {{ $story->title }}</x-fieldset.legend>

                <div class="flex items-center">
                    <x-button
                        wire:click="$dispatch('showStep', { toStepName: 'posts-wizard-step-setup' })"
                        size="xs"
                        plain
                    >
                        Edit post details
                    </x-button>
                </div>
            </div>
        </x-spacing>

        <x-spacing size="2xs">
            <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                @if (filled($post->characterAuthors))
                    <x-spacing size="md" class="grid grid-cols-3 gap-4">
                        @foreach ($post->characterAuthors as $character)
                            <div class="flex flex-col">
                                <x-text size="md">
                                    <x-text.strong>{{ $character->display_name }}</x-text.strong>
                                </x-text>
                                <div class="text-sm text-gray-500">played by {{ $character->pivot->user?->name }}</div>
                            </div>
                        @endforeach
                    </x-spacing>
                @endif

                @if (filled($post->userAuthors))
                    <x-spacing size="md" class="grid grid-cols-3 gap-4">
                        @foreach ($post->userAuthors as $user)
                            <div class="flex flex-col">
                                <x-text size="md">
                                    <x-text.strong>{{ $user->pivot->as ?? 'Additional character' }}</x-text.strong>
                                </x-text>
                                <div class="text-sm text-gray-500">played by {{ $user->name }}</div>
                            </div>
                        @endforeach
                    </x-spacing>
                @endif
            </x-panel>
        </x-spacing>
    </x-panel>

    <x-fieldset.controls>
        @if ($canSave)
            <div class="flex w-full items-center justify-between">
                <div class="flex items-center gap-x-2">
                    <x-button wire:click="goToNextStep" color="primary">Next: Publish post &rarr;</x-button>
                    <x-button wire:click="save" color="neutral">Save</x-button>
                </div>

                <div class="flex items-center">
                    @can('discardDraft', $post)
                        <x-dropdown placement="bottom-end">
                            <x-slot name="trigger" color="neutral-danger" leading="trash">Discard draft</x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to discard this {{ str($postType->name)->lower() }} draft?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item-danger
                                    type="button"
                                    icon="trash"
                                    wire:click="discardDraft({{ $post->id }})"
                                >
                                    Discard
                                </x-dropdown.item-danger>
                                <x-dropdown.item
                                    type="button"
                                    icon="prohibited"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    @endcan

                    @can('delete', $post)
                        <x-dropdown placement="bottom-start">
                            <x-slot name="trigger" color="neutral-danger" leading="trash">
                                Delete {{ str($postType->name)->lower() }}
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to delete the {{ str($postType->name)->lower() }}
                                    <strong class="font-semibold">{{ $post->title }}</strong>
                                    ?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item-danger
                                    type="button"
                                    icon="trash"
                                    wire:click="deletePost({{ $post->id }})"
                                >
                                    Delete
                                </x-dropdown.item-danger>
                                <x-dropdown.item
                                    type="button"
                                    icon="prohibited"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    @endcan
                </div>
            </div>
        @else
            <x-panel.warning class="w-full">
                {{ $canSaveMessage }}
            </x-panel.warning>
        @endif
    </x-fieldset.controls>
</x-write-post-wizard-layout>
