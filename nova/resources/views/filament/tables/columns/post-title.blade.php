@php
    declare(strict_types=1);

    $post = $getRecord();
@endphp

<div class="flex items-center space-x-2 px-6">
    <div class="mt-0.5 shrink-0" style="color: {{ $post->postType->color }}">
        @isset($post->postType->icon)
            <x-icon :name="$post->postType->icon" size="md"></x-icon>
        @else
            <div class="h-6 w-6"></div>
        @endisset
    </div>

    <div class="font-medium">
        {{ $post->title }}
    </div>
</div>
