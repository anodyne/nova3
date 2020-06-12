<span {{ $attributes->merge(['class' => "badge {$badgeSize} {$badgeType}"]) }}>
    {{ $slot }}
</span>
