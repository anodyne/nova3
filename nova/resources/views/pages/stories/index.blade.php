@extends($__novaTemplate)

@section('content')
    <x-page-header title="Stories">
        <x-slot name="controls">
            @if ($stories->count() > 0)
                @can('update', $stories->first())
                    <a href="{{ route('stories.index', 'reorder') }}" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4">
                        @icon('arrow-sort', 'h-6 w-6')
                    </a>
                @endcan

                <x-dropdown placement="bottom-end" class="flex items-center mr-4 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 {{ request()->has('type') ? 'text-blue-500' : '' }}">
                    <x-slot name="trigger">@icon('filter', 'h-6 w-6')</x-slot>

                    {{-- <a href="{{ route('stories.index', 'sort=sort,desc') }}" class="{{ $component->link() }} justify-between">
                        <span>Show only current stories</span>
                    </a>
                    <a href="{{ route('stories.index', 'sort=sort,asc') }}" class="{{ $component->link() }} justify-between">
                        <span>Show only upcoming stories</span>
                    </a>

                    <div class="{{ $component->divider() }}"></div> --}}

                    <a href="{{ route('stories.index', 'sort=asc') }}" class="{{ $component->link() }} justify-between">
                        <span>Sort by newest first</span>
                        @if (request('sort') === 'asc')
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                    <a href="{{ route('stories.index', 'sort=desc') }}" class="{{ $component->link() }} justify-between">
                        <span>Sort by oldest first</span>
                        @if (request('sort') === 'desc')
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                </x-dropdown>

                @can('create', 'Nova\Stories\Models\Story')
                    <a href="{{ route('stories.create') }}" class="button button-primary" data-cy="create">
                        Add Story
                    </a>
                @endcan
            @endif
        </x-slot>
    </x-page-header>

    @if ($stories->count() === 0)
        <x-empty-state
            image="book-lover"
            message="There is no greater power on this earth than story."
            label="Add your first story"
            :link="route('stories.create')"
        ></x-empty-state>
    @else
        <div class="relative w-full | sm:w-2/3">
            <x-stories.timeline :stories="$stories" />
        </div>
    @endif
@endsection
