<x-spacing class="col-span-3 grid grid-cols-subgrid" size="sm">
    <div class="mr-4 shrink-0">
        <x-logos.nova-mark-grayscale class="h-auto w-8 text-gray-500"></x-logos.nova-mark-grayscale>
    </div>

    <div class="col-start-2">
        <x-h3 class="leading-8">Nova 2.7.13+</x-h3>

        <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
            <p>
                If you’re planning to migrate an existing Nova 2 game, you’ll need to ensure that the existing game is
                running at least Nova 2.7.13.
            </p>
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        <x-icon :name="Icon::Help" class="text-warning-500" size="xl"></x-icon>
    </div>
</x-spacing>
