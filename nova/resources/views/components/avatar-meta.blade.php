@props([
    'src',
    'tooltip' => '',
    'size' => 'md',
    'primaryMeta' => '',
    'secondaryMeta' => '',
])

<div class="inline-flex items-center">
    <x-avatar :src="$src" :tooltip="$tooltip" :size="$size" />

    @if ($primaryMeta || $secondaryMeta)
        <div class="flex flex-col ml-4">
            @if ($primaryMeta)
                <div class="flex items-center font-medium truncate text-gray-900 dark:text-gray-100">
                    {{ $primaryMeta}}
                </div>
            @endif

            @if ($secondaryMeta)
                <div class="mt-1 flex items-center text-sm text-gray-600 dark:text-gray-400">
                    {{ $secondaryMeta }}
                </div>
            @endif
        </div>
    @endif
</div>
