@php
    $announcement = $getRecord();
    $currentUserHasSeen = $announcement->notifications->first()?->is_seen ?? true;
@endphp

<div class="flex items-center space-x-2 px-3">
    @unless ($currentUserHasSeen)
        <div class="size-2 rounded-full bg-primary-500"></div>
    @endunless

    <div class="whitespace-normal text-base font-medium text-gray-950 sm:text-sm dark:text-white">
        {{ $announcement->title }}
    </div>
</div>
