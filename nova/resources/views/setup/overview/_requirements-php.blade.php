<x-spacing size="sm">
    <div class="flex justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-icon name="tabler-brand-php" class="text-gray-500" size="xl"></x-icon>
            </div>
            <x-h3 class="flex-1">PHP 8.2+</x-h3>
        </div>
        <div class="flex justify-end">
            @if ($e->php->passes())
                <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
            @else
                <x-icon name="tabler-circle-x" class="text-danger-500" size="xl"></x-icon>
            @endif
        </div>
    </div>
    <div class="ml-12 mt-2 max-w-lg space-y-4 text-sm/6 font-normal text-gray-500">
        <p>
            Nova is web-based software written in PHP. To ensure the best possible experience, we recommend using the
            latest version of PHP.
        </p>

        <p>Your server is currently running PHP {{ $e->php->version }}.</p>
    </div>
</x-spacing>
