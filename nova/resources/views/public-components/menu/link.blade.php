<a href="{{ $item->link }}" target="{{ $item->target->value }}">
    @if (filled($item->icon))
        <x-icon :name="$item->icon" />
    @endif

    <span>{{ $item->label }}</span>
</a>
