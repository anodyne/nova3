@extends($meta->template)

@section('content')
    <x-page-header title="Stories">
        <x-slot name="controls">
            @if ($storyCount > 0)
                <x-dropdown placement="bottom-start md:bottom-end">
                    <x-slot name="trigger">@icon('filter', 'h-7 w-7 md:h-6 md:w-6')</x-slot>

                    <x-dropdown.group>
                        <x-dropdown.item :href="route('stories.index', 'sort=asc')">
                            <div class="flex items-center justify-between w-full">
                                <span>Sort by newest first</span>
                                @if (request('sort', 'desc') === 'asc')
                                    @icon('check', 'h-6 w-6 md:h-5 md:w-5 shrink-0 text-blue-9')
                                @endif
                            </div>
                        </x-dropdown.item>
                        <x-dropdown.item :href="route('stories.index', 'sort=desc')">
                            <div class="flex items-center justify-between w-full">
                                <span>Sort by oldest first</span>
                                @if (request('sort', 'desc') === 'desc')
                                    @icon('check', 'h-6 w-6 md:h-5 md:w-5 shrink-0 text-blue-9')
                                @endif
                            </div>
                        </x-dropdown.item>
                    </x-dropdown.group>
                </x-dropdown>

                @can('create', 'Nova\Stories\Models\Story')
                    <x-link :href="route('stories.create')" color="blue" data-cy="create">
                        Add Story
                    </x-link>
                @endcan
            @endif
        </x-slot>
    </x-page-header>

    @if ($storyCount === 0)
        <x-empty-state
            image="book-lover"
            message="There is no greater power on this earth than story."
            label="Add your first story"
            :link="route('stories.create')"
        ></x-empty-state>
    @else
        @livewire('stories:timeline')
    @endif

    <x-tips section="stories" />
@endsection
