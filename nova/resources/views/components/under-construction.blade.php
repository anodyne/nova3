@props(['feature'])

<div class="rounded-md bg-warning-50 border border-warning-300 p-4 mb-8">
    <div class="flex">
        <div class="shrink-0">
            <x-icon name="warning" size="lg" class="text-warning-500"></x-icon>
        </div>
        <div class="ml-3">
            <h3 class="font-medium text-warning-600">
                The {{ $feature }} feature is still being developed. The following items are not working as intended:
            </h3>

            <div class="mt-2 text-sm text-warning-600">
                <ul class="list-disc pl-5 space-y-1">
                    {{ $slot }}
                </ul>
            </div>
        </div>
    </div>
</div>
