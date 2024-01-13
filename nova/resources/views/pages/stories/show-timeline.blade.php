@extends($meta->template)

@section('content')
    <div x-data="{ active: 'posts' }">
        <div class="grid grid-cols-2">
            <a
                href="{{ route('stories.timeline', 'posts') }}"
                @class([
                    'flex gap-3 px-8 py-4',
                    'rounded-lg bg-gray-100 ring-1 ring-inset ring-gray-950/5 dark:bg-white/5 dark:ring-white/5' => $type === 'posts',
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
                    <x-text>Posts follow a linear path that helps better organize your story chronologically</x-text>
                </div>
            </a>

            <a
                href="{{ route('stories.timeline', 'stories') }}"
                @class([
                    'flex gap-3 px-8 py-4',
                    'rounded-lg bg-gray-100 ring-1 ring-inset ring-gray-950/5 dark:bg-white/5 dark:ring-white/5' => $type === 'stories',
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
                    <x-text>Stories live on a timeline and provide important historical context for the game</x-text>
                </div>
            </a>
        </div>

        <div class="mt-8">
            @if ($type === 'stories')
                <livewire:stories-timeline />
            @else
                <livewire:posts-timeline />
            @endif
        </div>
    </div>
@endsection
