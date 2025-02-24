@use('Illuminate\Support\Number')

{{--
    <x-modal title="Publish post" icon="check-circle">
    <x-form action="">
    @if ($shouldShowParticipantsPanel || $shouldShowPositionPanel)
    <flux:tab.group>
    <flux:tabs variant="pills">
    @if ($shouldShowParticipantsPanel)
    <flux:tab name="participants">Post participants</flux:tab>
    @endif
    
    @if ($shouldShowPositionPanel)
    <flux:tab name="position">Post position</flux:tab>
    @endif
    </flux:tabs>
    
    @if ($shouldShowParticipantsPanel)
    <flux:tab.panel name="participants">
    <x-panel variant="well">
    <x-panel.header title="Review participants" icon="user-scan" icon-size="lg">
    <x-slot name="description">
    Review players who participated in writing this post to ensure that the proper authors are credited.
    If there’s someone here who did not participate (indicated by a red status badge), you can remove
    them. If there’s someone who did participate and isn’t listed here, you can add them from the authors
    section.
    </x-slot>
    </x-panel.header>
    
    <x-panel>
    <div class="divide-y divide-gray-950/5 rounded-b-lg dark:divide-white/5">
    @foreach ($post->participatingUsers as $participatingUser)
    <x-spacing size="row" class="flex items-center justify-between gap-6">
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
    
    <div class="flex items-center gap-x-4">
    <div class="tabular-nums text-sm/6">
    {{ Number::format($participatingUser?->pivot?->word_count) }}
    {{ str('word')->plural($participatingUser?->pivot?->word_count) }}
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
    and any characters they’re marked as writing as authors of this post?
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
    </div>
    </x-spacing>
    @endforeach
    </div>
    </x-panel>
    
    @if ($hasNonParticipants)
    <x-panel.footer>
    <x-dropdown placement="bottom-start">
    <x-slot name="trigger" color="neutral-danger">
    <div class="flex items-center gap-2">
    <x-icon name="remove" size="sm"></x-icon>
    <span>Remove all non-participating users</span>
    </div>
    </x-slot>
    
    <x-dropdown.group>
    <x-dropdown.text>
    Are you sure you want to remove all users who did not participate in writing
    this post and their characters?
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
    </x-panel.footer>
    @endif
    </x-panel>
    </flux:tab.panel>
    @endif
    
    @if ($shouldShowPositionPanel)
    <flux:tab.panel name="position">
    <x-panel variant="well">
    <x-panel.header title="Set final post position" icon="timeline" icon-size="lg" description="Posts live on a timeline which allows you to set exactly where this post should appear in the story’s timeline."></x-panel.header>
    
    <x-panel>
    <x-spacing size="md">
    <x-timeline>
    @if ($previousPost)
    <x-timeline.item class="bg-gray-400 ring-white dark:bg-gray-500 dark:ring-gray-900">
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
    </x-panel>
    </flux:tab.panel>
    @endif
    </flux:tab.group>
    @else
    <x-fieldset>
    <x-text>Id sit incididunt esse laborum exercitation culpa elit consequat aute magna amet officia exercitation. Amet ad exercitation culpa. Sunt officia consequat occaecat sit amet sit velit non ipsum mollit pariatur aliqua nostrud.</x-text>
    </x-fieldset>
    @endif
    
    <x-fieldset.controls>
    <x-button type="button" wire:click="save" color="primary">Publish</x-button>
    <x-button type="button" wire:click="dismiss">Cancel</x-button>
    </x-fieldset.controls>
    </x-form>
    </x-modal>
--}}

<x-modal.slide-over title="Publish post" icon="check-circle">
    <div>
        <label>Your email</label>
        <input type="email" placeholder="demo@wire-elements.dev" />
    </div>

    <x-slot name="footer">
        <x-button color="primary">Save Changes</x-button>
        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
