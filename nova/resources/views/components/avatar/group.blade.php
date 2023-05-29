@props([
    'size' => 'md',
    'items' => [],
    'limit' => 4,
])

<div class="flex -space-x-2 overflow-hidden">
    @foreach ($items as $item)
        <x-avatar :src="$item->avatar_url" :size="$size" :tooltip="$item->name" class="ring-2 ring-white dark:ring-gray-900"></x-avatar>
    @endforeach

    {{ $slot }}
</div>
