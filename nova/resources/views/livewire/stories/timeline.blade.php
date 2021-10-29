<x-panel>
    @if ($selectedStory)
        <x-content-box height="xs" class="sticky top-0 z-30 bg-gray-2 backdrop-filter backdrop-blur bg-opacity-50 border-t border-b border-gray-6 sm:rounded-t-lg sm:border-t-0">
            <div class="flex items-center leading-0 space-x-8">
                <span class="font-bold tracking-tight text-gray-12">{{ $selectedStory->title }}</span>

                @can('view', $selectedStory)
                    <x-link :href="route('stories.show', $selectedStory)" size="none" color="gray-text">
                        @icon('show', 'h-5 w-5')
                        <span>View</span>
                    </x-link>
                @endcan

                @can('update', $selectedStory)
                    <x-link :href="route('stories.edit', $selectedStory)" size="none" color="gray-text">
                        @icon('edit', 'h-5 w-5')
                        <span>Edit</span>
                    </x-link>
                @endcan

                @can('view', $selectedStory)
                    <x-link href="#" size="none" color="gray-text">
                        @icon('list', 'h-5 w-5')
                        <span>Posts</span>
                    </x-link>
                @endcan

                @can('delete', $selectedStory)
                    <x-button size="none" color="gray-text">
                        @icon('delete', 'h-5 w-5')
                        <span>Delete</span>
                    </x-button>
                @endcan

                @can('update', $selectedStory)
                    <span>
                        @livewire('stories:status', ['story' => $selectedStory], key("status-{{ $selectedStory->id }}"))
                    </span>
                @endcan
            </div>
        </x-content-box>
    @endif

    <x-content-box height="xs" width="xs">
        <div class="w-full">
            <x-stories.timeline :stories="$this->stories" />
        </div>
    </x-content-box>
</x-panel>