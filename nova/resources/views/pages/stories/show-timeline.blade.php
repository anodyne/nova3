@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden" x-data="{ active: 'posts' }">
        <div class="grid grid-cols-2">
            <a
                href="{{ route('stories.timeline', 'posts') }}"
                @class([
                    'flex gap-3 px-8 py-4',
                    'rounded-br-md border-b border-r border-gray-200 bg-gray-100' => $type !== 'posts',
                ])
            >
                <div
                    @class([
                        'shrink-0',
                        'text-primary-500' => $type === 'posts',
                    ])
                >
                    <x-icon name="book" size="xl"></x-icon>
                </div>
                <div class="flex flex-col gap-1 text-left">
                    <x-h2>Posts timeline</x-h2>
                    <p class="text-sm text-gray-500">
                        Posts follow a linear path that helps better organize your story chronologically
                    </p>
                </div>
            </a>

            <a
                href="{{ route('stories.timeline', 'stories') }}"
                @class([
                    'flex gap-3 px-8 py-4',
                    'rounded-bl-md border-b border-l border-gray-200 bg-gray-100' => $type !== 'stories',
                ])
            >
                <div
                    @class([
                        'shrink-0',
                        'text-primary-500' => $type === 'stories',
                    ])
                >
                    <x-icon name="books" size="xl"></x-icon>
                </div>
                <div class="flex flex-col gap-1 text-left">
                    <x-h2>Stories timeline</x-h2>
                    <p class="text-sm text-gray-500">
                        Stories live on a timeline and provide important historical context for the game
                    </p>
                </div>
            </a>
        </div>

        <div>
            @if ($type === 'stories')
                <livewire:stories-timeline />
            @else
                <livewire:posts-timeline />
            @endif
        </div>
    </x-panel>
@endsection
