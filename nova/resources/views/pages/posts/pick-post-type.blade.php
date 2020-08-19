@extends($__novaTemplate)

@section('writing.leading')
    <a href="#" class="flex items-center text-gray-500 text-xs tracking-wide font-semibold">
        @icon('chevron-left', 'h-4 w-4 text-gray-400')
        <span class="ml-1">Back</span>
    </a>

    <div class="font-bold text-lg">Choose a Post Type</div>
@endsection

@section('content')
    <div class="text-center">
        <h2 class="font-extrabold text-3xl">Choose a Post Type</h2>
    </div>

    <div class="mt-12 max-w-4xl mx-auto">
        <div class="grid gap-6 max-w-lg mx-auto | md:grid-cols-2 lg:grid-cols-4 lg:max-w-none">
            @foreach ($postTypes as $postType)
                @can('write', $postType)
                    <a href="{{ route('posts.compose', $postType) }}" class="rounded-md bg-white shadow hover:border-blue-400 transition ease-in-out duration-150 overflow-hidden hover:shadow-lg">
                        <div class="h-1.5 w-full" style="background-color:{{ $postType->color }}"></div>

                        <div class="p-4 | sm:p-6">
                            <div class="flex flex-col items-center">
                                <span style="color:{{ $postType->color }}">
                                    @icon($postType->icon, 'h-12 w-12')
                                </span>

                                <h3 class="inline-flex items-center text-lg font-semibold text-gray-900 mt-4">
                                    {{ $postType->name }}
                                </h3>

                                @if ($postType->role)
                                    <x-badge size="sm" class="mt-1">{{ $postType->role->display_name }}</x-badge>
                                @endif
                            </div>
                        </div>
                    </a>
                @endcan
            @endforeach
        </div>
    </div>

@endsection
