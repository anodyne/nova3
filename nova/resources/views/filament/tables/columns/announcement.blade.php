@php
    $announcement = $getRecord();
    $currentUserHasSeen = $announcement->notifications->first()?->is_seen ?? true;
@endphp

<div class="flex items-center space-x-2 px-3">
    @if (! $currentUserHasSeen && $announcement->is_published)
        <div class="bg-primary-500 size-2 rounded-full"></div>
    @endif

    <div class="text-base font-medium whitespace-normal text-gray-950 sm:text-sm dark:text-white">
        {{ $announcement->title }}
    </div>
</div>
