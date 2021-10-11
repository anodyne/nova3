@extends($meta->template)

@section('content')
    <div class="text-center">
        <h2 class="font-extrabold text-3xl">Choose a Post Type</h2>
    </div>

    <div class="mt-12 max-w-4xl mx-auto">
        <div class="grid gap-6 max-w-lg mx-auto md:grid-cols-2 lg:grid-cols-4 lg:max-w-none">
            @foreach ($postTypes as $postType)
                <a href="{{ route('posts.compose', $postType) }}" class="flex flex-col items-center rounded-lg bg-gray-1 shadow focus:outline-none transition ease-in-out duration-150 overflow-hidden hover:shadow-lg">
                    <div class="h-1.5 w-full" style="background-color:{{ $postType->color }}"></div>

                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col items-center">
                            @isset($postType->icon)
                                <span style="color:{{ $postType->color }}">
                                    @icon($postType->icon, 'h-12 w-12')
                                </span>
                            @else
                                <div class="h-12 w-12"></div>
                            @endif

                            <h3 class="inline-flex items-center text-lg font-semibold text-gray-900 mt-4">
                                {{ $postType->name }}
                            </h3>

                            @if ($postType->role)
                                <x-badge size="xs" color="gray" class="mt-1">{{ $postType->role->display_name }}</x-badge>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
