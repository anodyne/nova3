@props([
    'icon',
    'entity',
    'message' => false,
    'primary' => false,
    'primaryAccess' => false,
    'secondary' => false,
    'search' => '',
])

@php
    $entityPlural = str($entity)->plural()
@endphp

<div class="py-8 md:py-16 space-y-6">
    <div class="flex flex-col items-center max-w-xs mx-auto sm:max-w-sm md:max-w-xl space-y-8">
        <div class="text-center">
            <x-badge color="warning" size="circle" icon>
                <x-icon name="warning" size="h-12 w-12"></x-icon>
            </x-badge>
        </div>

        <div class="space-y-3">
            <h2 class="text-center font-semibold text-gray-900 dark:text-white">
                @if ($message)
                    {{ $message }}
                @else
                    No {{ $entityPlural }} found
                @endif
            </h2>

            <p class="text-center text-gray-600 dark:text-gray-400 leading-relaxed">
                Your search &ldquo;{{ $search }}&rdquo; did not match any {{ $entityPlural }}. Please try again{{ $primaryAccess ? " or add a new {$entity}" : '' }}.
            </p>
        </div>

        <div class="space-x-6">
            @if ($primary && $primaryAccess)
                {{ $primary }}
            @endif

            @if ($secondary)
                {{ $secondary }}
            @endif
        </div>
    </div>
</div>
