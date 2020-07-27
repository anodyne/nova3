@extends($__novaTemplate)

@section('content')
    <x-page-header title="Stories">
        <x-slot name="controls">
            @can('update', $stories->first())
                <a href="{{ route('stories.index', 'reorder') }}" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4">
                    @icon('arrow-sort', 'h-6 w-6')
                </a>
            @endcan

            <x-dropdown placement="bottom-end" class="flex items-center mr-4 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 {{ request()->has('type') ? 'text-blue-500' : '' }}">
                @icon('filter', 'h-6 w-6')

                <x-slot name="dropdown">
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
                </x-slot>
            </x-dropdown>

            @can('create', 'Nova\Stories\Models\Story')
                <a href="{{ route('stories.index') }}" class="button button-primary" data-cy="create">
                    Add Story
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <div class="relative w-full | sm:w-2/3">
        <x-stories.timeline :stories="$stories" />
    </div>
@endsection
