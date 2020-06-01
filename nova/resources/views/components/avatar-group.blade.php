<div class="flex relative z-0 overflow-hidden">
@foreach ($items as $index => $item)
    <x-avatar :url="$item->avatar_url" :size="$size" :tooltip="$item->name" :class="$styles($index)" />
@endforeach
</div>
