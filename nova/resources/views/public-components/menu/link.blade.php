<a href="{{ $item->link }}" target="{{ $item->target->value }}">
    @if (filled($item->icon))
        <x-icon :name="$item->icon_name"></x-icon>
    @endif

    <span>{{ $item->label }}</span>
</a>
