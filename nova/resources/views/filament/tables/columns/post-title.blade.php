@php
    declare(strict_types=1);

    $post = $getRecord();

    $tight ??= false;
    $locked ??= true;
@endphp

<div @class([
    'flex items-center space-x-2',
    'px-2' => ! $tight,
])>
    <div class="mt-0.5 shrink-0" style="color: {{ $post->postType->color }}">
        @isset($post->postType->icon)
            <x-icon :name="$post->postType->icon" size="md" />
        @else
            <div class="size-6"></div>
        @endisset
    </div>

    <div class="text-base font-medium whitespace-normal sm:text-sm">
        {{ $post->title ?? '(No title)' }}
    </div>

    @if ($locked && $post->isLocked())
        <div class="shrink-0 text-gray-500 dark:text-gray-400">
            <x-icon.micro.lock-closed></x-icon.micro.lock-closed>
        </div>
    @endif
</div>
