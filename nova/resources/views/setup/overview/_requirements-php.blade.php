<x-spacing class="col-span-3 grid grid-cols-subgrid" size="sm">
    <div class="mr-4 shrink-0">
        <x-icon :name="Icon::BrandPhp" class="text-gray-500" size="xl"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h3 class="leading-8">PHP 8.3+</x-h3>

        <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
            <p>
                Nova is web-based software written in PHP. To ensure the best possible experience, we recommend using
                the latest version of PHP.
            </p>

            <p>Your server is currently running PHP {{ $e->php->version }}.</p>
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($e->php->passes())
            <x-icon :name="Icon::CheckCircle" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-icon :name="Icon::XmarkCircle" class="text-danger-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
