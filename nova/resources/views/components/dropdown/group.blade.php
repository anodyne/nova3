<div
    {{ $attributes->merge(['class' => 'p-1.5 has-[[data-slot=search]]:p-0']) }}
    role="menu"
    aria-orientation="vertical"
>
    {{ $slot }}
</div>
