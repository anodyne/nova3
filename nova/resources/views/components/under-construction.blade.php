@props(['feature'])

<div class="rounded-md bg-yellow-3 border border-yellow-6 p-4 mb-8">
    <div class="flex">
        <div class="flex-shrink-0">
            @icon('warning', 'h-7 w-7 text-yellow-9')
        </div>
        <div class="ml-3">
            <h3 class="font-medium text-yellow-11">
                The {{ $feature }} feature is still being developed. The following items are not working as intended:
            </h3>

            <div class="mt-2 text-sm text-yellow-11">
                <ul class="list-disc pl-5 space-y-1">
                    {{ $slot }}
                </ul>
            </div>
        </div>
    </div>
</div>
