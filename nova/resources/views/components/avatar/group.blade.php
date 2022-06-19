<div class="flex -space-x-2 overflow-hidden">
    @foreach ($items as $item)
        <x-avatar :src="$item->avatar_url" :size="$size" :tooltip="$item->name" :class="$styles()"></x-avatar>
    @endforeach

    {{ $slot }}
</div>
