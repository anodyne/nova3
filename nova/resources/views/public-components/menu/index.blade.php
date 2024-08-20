@props(['items'])

<ul>
    @foreach ($items ?? [] as $item)
        @if (count($item->items) > 0)
            <x-public::menu.dropdown :item="$item"></x-public::menu.dropdown>
        @else
            <x-public::menu.item :item="$item"></x-public::menu.item>
        @endif
    @endforeach
</ul>
