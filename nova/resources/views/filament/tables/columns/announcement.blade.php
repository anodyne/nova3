@php
    declare(strict_types=1);

    $announcement = $getRecord();
@endphp

<div class="flex items-center space-x-2 px-3">
    @if ($announcement->unreadFor(auth()->user()))
        <div class="size-2 rounded-full bg-primary-500"></div>
    @endif

    <div class="whitespace-normal text-base font-medium text-gray-950 dark:text-white sm:text-sm">
        {{ $announcement->title }}
    </div>
</div>
