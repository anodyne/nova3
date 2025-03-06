<div wire:cloak>
    <div class="grid gap-12 lg:grid-cols-3">
        <section class="space-y-12 lg:col-span-2">
            <livewire:posts-details :$post @post-updated="handleUpdateFromChild" />

            <div class="flex items-center gap-x-2">
                @if ($postIsDirty)
                    <x-panel variant="well" color="warning">
                        <x-spacing height="3xs" left="3xs" right="sm" class="flex items-center gap-x-3">
                            <x-button wire:click="save" color="warning">Save</x-button>
                            <x-text color="warning" class="font-medium">There are unsaved changes to your post</x-text>
                        </x-spacing>
                    </x-panel>
                @else
                    <x-spacing height="3xs" left="3xs" right="sm">
                        <x-button wire:click="save">Save</x-button>
                    </x-spacing>
                @endif
            </div>
        </section>

        <aside class="space-y-12">
            <flux:accordion>
                <flux:accordion.item expanded transition>
                    <flux:accordion.heading>
                        <div class="flex items-center gap-x-2">
                            <x-icon name="characters" size="sm"></x-icon>
                            <span>Authors</span>
                        </div>
                    </flux:accordion.heading>

                    <flux:accordion.content>
                        <livewire:posts-authors :$post @post-updated="handleUpdateFromChild" />
                    </flux:accordion.content>
                </flux:accordion.item>

                @if ($post?->postType?->fields?->rating?->enabled ?? false)
                    <flux:accordion.item expanded transition>
                        <flux:accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon name="mature" size="sm"></x-icon>
                                <span>Content ratings</span>
                            </div>
                        </flux:accordion.heading>

                        <flux:accordion.content>
                            <livewire:posts-ratings :$post @post-updated="handleUpdateFromChild" />
                        </flux:accordion.content>
                    </flux:accordion.item>
                @endif

                @if ($post?->postType?->fields?->summary?->enabled ?? false)
                    <flux:accordion.item expanded transition>
                        <flux:accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon name="blockquote" size="sm"></x-icon>
                                <span>Summary</span>
                            </div>
                        </flux:accordion.heading>

                        <flux:accordion.content>
                            <x-button plain>Update summary &rarr;</x-button>
                        </flux:accordion.content>
                    </flux:accordion.item>
                @endif

                @if ($post->exists)
                    <flux:accordion.item expanded transition>
                        <flux:accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon name="timeline" size="sm"></x-icon>
                                <span>Post position</span>
                            </div>
                        </flux:accordion.heading>

                        <flux:accordion.content>
                            <livewire:posts-position :$post @post-updated="handleUpdateFromChild" />
                        </flux:accordion.content>
                    </flux:accordion.item>
                @endif
            </flux:accordion>
        </aside>
    </div>
</div>
