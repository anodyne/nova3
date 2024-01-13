<x-write-post-wizard-layout
    :steps="$steps"
    message="Set your post’s content rating, summary, and position within the story before publishing"
>
    @if ($postType->fields->rating->enabled)
        <x-fieldset>
            <x-fieldset.heading>
                <x-icon name="mature"></x-icon>
                <x-fieldset.legend>Content ratings</x-fieldset.legend>
                <x-fieldset.description>
                    Let players and readers know what to expect from your post by setting the content ratings. These
                    content ratings follow the game’s default ratings unless you specify otherwise.
                </x-fieldset.description>
            </x-fieldset.heading>

            <x-fieldset.field-group constrained>
                <x-fieldset.field label="Language" id="language" name="language" class="w-full">
                    <livewire:rating area="language" wire:model.live.number="form.rating_language" />
                </x-fieldset.field>

                <x-fieldset.field label="Sex" id="sex" name="sex" class="w-full">
                    <livewire:rating area="sex" wire:model.live.number="form.rating_sex" />
                </x-fieldset.field>

                <x-fieldset.field label="Violence" id="violence" name="violence" class="w-full">
                    <livewire:rating area="violence" wire:model.live.number="form.rating_violence" />
                </x-fieldset.field>
            </x-fieldset.field-group>
        </x-fieldset>
    @endif

    @if ($postType->fields->summary->enabled)
        <x-fieldset>
            <x-fieldset.heading>
                <x-icon name="blockquote"></x-icon>
                <x-fieldset.legend>Post summary</x-fieldset.legend>
                <x-fieldset.description>
                    If your post contains content intended only for mature audiences or that could be difficult for some
                    people to read, you can provide a summary of the post.
                </x-fieldset.description>
            </x-fieldset.heading>

            <x-fieldset.field-group constrained>
                <x-input.textarea wire:model.blur="form.summary" rows="5"></x-input.textarea>
            </x-fieldset.field-group>
        </x-fieldset>
    @endif

    @if ($shouldShowParticipantsPanel)
        <x-fieldset>
            <x-fieldset.heading>
                <x-icon name="user-scan"></x-icon>
                <x-fieldset.legend>Review participants</x-fieldset.legend>
                <x-fieldset.description>
                    You can review players who participated in writing this post to ensure that the proper authors are
                    credited.
                </x-fieldset.description>
            </x-fieldset.heading>

            <x-fieldset.field-group constrained-lg>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Post authors</x-fieldset.legend>
                        <x-fieldset.description>
                            If there’s someone here who did not participate (indicated by a red status badge), you can
                            remove them. If there’s someone who did participate and isn’t listed here, you can add them
                            from the
                            <x-text.link
                                type="button"
                                wire:click="$dispatch('showStep', { toStepName: 'posts-wizard-step-setup' })"
                            >
                                Setup Post
                            </x-text.link>
                            screen.
                        </x-fieldset.description>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <div class="divide-y divide-gray-950/5 rounded-b-lg dark:divide-white/5">
                                @foreach ($participatingUsers as $participatingUser)
                                    <x-spacing height="xs" width="sm" class="flex items-center justify-between gap-6">
                                        <div class="flex flex-col space-x-3 sm:flex-row sm:items-center">
                                            <div class="flex flex-col gap-0.5">
                                                <div class="flex items-center">
                                                    <span
                                                        @class([
                                                            'mr-3 inline-block h-2 w-2 shrink-0 rounded-full',
                                                            'bg-success-500' => in_array($participatingUser->id, $post->participants ?? []),
                                                            'bg-danger-500' => ! in_array($participatingUser->id, $post->participants ?? []),
                                                        ])
                                                    ></span>
                                                    <span class="font-medium">{{ $participatingUser->name }}</span>
                                                </div>
                                                <div class="ml-5">
                                                    @foreach ($post->characterAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $character)
                                                        <div class="text-sm">{{ $character->displayName }}</div>
                                                    @endforeach

                                                    @foreach ($post->userAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $user)
                                                        <div class="text-sm italic">{{ $user->pivot->as }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <x-dropdown placement="bottom-end">
                                            <x-slot name="trigger" color="neutral-danger">
                                                <x-icon name="remove" size="md"></x-icon>
                                            </x-slot>

                                            <x-dropdown.group>
                                                <x-dropdown.text>
                                                    Are you sure you want to remove
                                                    <strong class="font-semibold text-gray-700 dark:text-gray-950/5">
                                                        {{ $participatingUser->name }}
                                                    </strong>
                                                    and any characters they’re marked as writing as authors of this
                                                    post?
                                                </x-dropdown.text>
                                            </x-dropdown.group>
                                            <x-dropdown.group>
                                                <x-dropdown.item-danger
                                                    type="button"
                                                    icon="remove"
                                                    wire:click="removeParticipant({{ $participatingUser }})"
                                                >
                                                    Remove
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
                                    </x-spacing>
                                @endforeach

                                @if ($hasNonParticipants)
                                    <x-spacing
                                        height="xs"
                                        width="sm"
                                        class="flex items-center rounded-b-lg bg-gray-950/[.025] dark:bg-white/[.025]"
                                    >
                                        <x-dropdown placement="bottom-start">
                                            <x-slot name="trigger" color="neutral-danger">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="remove" size="md"></x-icon>
                                                    <span>Remove all non-participating users</span>
                                                </div>
                                            </x-slot>

                                            <x-dropdown.group>
                                                <x-dropdown.text>
                                                    Are you sure you want to remove all users who did not participate in
                                                    writing this post and their characters?
                                                </x-dropdown.text>
                                            </x-dropdown.group>
                                            <x-dropdown.group>
                                                <x-dropdown.item-danger
                                                    type="button"
                                                    icon="remove"
                                                    wire:click="removeAllNonParticipants"
                                                >
                                                    Remove all
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
                                    </x-spacing>
                                @endif
                            </div>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset.field-group>
        </x-fieldset>
    @endif

    @if ($shouldShowPositionPanel)
        <x-fieldset>
            <x-fieldset.heading>
                <x-icon name="timeline"></x-icon>
                <x-fieldset.legend>Post position</x-fieldset.legend>
                <x-fieldset.description>
                    Posts live on a timeline which allows you to set exactly where this post should appear in the
                    story’s timeline.
                </x-fieldset.description>
            </x-fieldset.heading>

            <x-fieldset.field-group constrained-lg>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Set final post position</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <x-timeline>
                                    @if ($previousPost)
                                        <x-timeline.item
                                            class="bg-gray-400 ring-white dark:bg-gray-500 dark:ring-gray-900"
                                        >
                                            <x-slot name="title">
                                                <div class="flex items-center gap-x-6">
                                                    <x-h3>{{ $previousPost?->title }}</x-h3>
                                                    <x-badge>{{ $previousPost?->postType?->name }}</x-badge>
                                                </div>
                                            </x-slot>

                                            <div>
                                                <x-timeline.post-meta-fields
                                                    :post="$previousPost"
                                                    class="mt-1.5"
                                                ></x-timeline.post-meta-fields>

                                                <x-button
                                                    type="button"
                                                    wire:click="$dispatch('openModal', { component: 'posts-read-post-modal', arguments: { post: {{ $previousPost->id }}}})"
                                                    color="neutral"
                                                    class="mt-5"
                                                >
                                                    Read &rarr;
                                                </x-button>
                                            </div>
                                        </x-timeline.item>
                                    @endif

                                    <x-timeline.item
                                        class="bg-primary-500 ring-primary-500"
                                        highlighted
                                        :last="$nextPost === null"
                                    >
                                        <x-slot name="title">
                                            <div class="flex items-center gap-x-6">
                                                <x-h2>{{ $post?->title }}</x-h2>
                                                <x-badge>{{ $post?->postType?->name }}</x-badge>
                                            </div>
                                        </x-slot>

                                        <div>
                                            <x-timeline.post-meta-fields
                                                :post="$post"
                                                class="mt-1.5"
                                            ></x-timeline.post-meta-fields>

                                            <x-button
                                                type="button"
                                                wire:click="$dispatch('openModal', { component: 'posts-select-post-position-modal', arguments: { story: {{ $post->story_id }}}})"
                                                color="neutral"
                                                class="mt-5"
                                            >
                                                <div class="flex items-center gap-x-2">
                                                    <x-icon
                                                        name="arrows-sort"
                                                        size="sm"
                                                        class="shrink-0 text-gray-400"
                                                    ></x-icon>
                                                    <span>Change post position</span>
                                                </div>
                                            </x-button>
                                        </div>
                                    </x-timeline.item>

                                    @if ($nextPost)
                                        <x-timeline.item
                                            class="bg-gray-400 ring-white dark:bg-gray-500 dark:ring-gray-900"
                                            last
                                        >
                                            <x-slot name="title">
                                                <div class="flex items-center gap-x-6">
                                                    <x-h3>{{ $nextPost?->title }}</x-h3>
                                                    <x-badge>{{ $nextPost?->postType?->name }}</x-badge>
                                                </div>
                                            </x-slot>

                                            <div>
                                                <x-timeline.post-meta-fields
                                                    :post="$nextPost"
                                                    class="mt-1.5"
                                                ></x-timeline.post-meta-fields>

                                                <x-button
                                                    type="button"
                                                    wire:click="$dispatch('openModal', { component: 'posts-read-post-modal', arguments: { post: {{ $nextPost->id }}}})"
                                                    color="neutral"
                                                    class="mt-5"
                                                >
                                                    Read &rarr;
                                                </x-button>
                                            </div>
                                        </x-timeline.item>
                                    @endif
                                </x-timeline>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset.field-group>
        </x-fieldset>
    @endif

    <div
        class="flex flex-col rounded-b-lg border-t border-gray-950/5 px-4 py-4 md:flex-row md:items-center md:justify-between md:px-6 md:py-6 dark:border-white/5"
    >
        <div class="flex items-center">
            @can('discardDraft', $post)
                <x-dropdown placement="bottom-start">
                    <x-slot name="trigger" color="neutral-danger" leading="trash">Discard draft</x-slot>

                    <x-dropdown.group>
                        <x-dropdown.text>
                            Are you sure you want to discard this {{ str($postType->name)->lower() }} draft?
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="discardDraft({{ $post->id }})">
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
                            Are you sure you want to delete this {{ str($postType->name)->lower() }}?
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="deletePost({{ $post->id }})">
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

        <div class="flex items-center gap-4">
            @if ($post->is_published)
                <x-button wire:click="save" color="primary">Update post</x-button>
            @else
                <x-button wire:click="save" color="neutral">Save</x-button>
                <x-button wire:click="publish" color="primary">Publish post</x-button>
            @endif
        </div>
    </div>
</x-write-post-wizard-layout>
