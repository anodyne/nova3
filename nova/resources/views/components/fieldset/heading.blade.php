<div
    data-slot="heading"
    @class([
        // Base layout
        'grid grid-cols-[1.5rem_1fr] items-center gap-x-3 sm:grid-cols-[1.5rem_1fr]',

        // Icon layout
        '[&>[data-slot=icon]]:col-start-1 [&>[data-slot=icon]]:row-start-1 [&>[data-slot=icon]]:flex [&>[data-slot=icon]]:size-7 [&>[data-slot=icon]]:items-center [&>[data-slot=icon]]:justify-self-center [&>[data-slot=icon]]:text-gray-500',

        // Legend layout
        '[&>[data-slot=legend]]:col-start-2 [&>[data-slot=legend]]:row-start-1 [&>[data-slot=legend]]:justify-self-start [&>[data-slot=legend]]:text-lg sm:[&>[data-slot=legend]]:text-base',

        // Description layout
        '[&>[data-slot=description]]:col-start-2 [&>[data-slot=description]]:row-start-2',
    ])
>
    {{ $slot }}
</div>
