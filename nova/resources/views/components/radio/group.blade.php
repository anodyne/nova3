<div
    data-slot="control"
    {{ $attributes->merge(['class' => 'space-y-3 [&_[data-slot=label]]:font-normal has-[[data-slot=description]]:space-y-6 [&_[data-slot=label]]:has-[[data-slot=description]]:font-medium']) }}
>
    {{ $slot }}
</div>
