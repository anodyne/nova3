@php
    declare(strict_types=1);

    $postType = $getRecord();
@endphp

<div class="flex items-center space-x-2 px-6">
    <div class="mt-0.5 shrink-0" style="color: {{ $postType->color }}">
        @isset($postType->icon)
            <x-icon :name="$postType->icon" size="md"></x-icon>
        @else
            <div class="size-6"></div>
        @endisset
    </div>

    <div class="text-base font-medium sm:text-sm">
        {{ $postType->name }}
    </div>
</div>
