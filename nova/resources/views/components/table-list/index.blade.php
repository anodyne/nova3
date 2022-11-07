@props([
    'columns' => false,
    'emptyMessage' => false,
    'footer' => false,
    'header' => false,
])

<ul class="divide-y divide-gray-200 dark:divide-gray-200/10" {{ $attributes }}>
    @if ($header)
        <li class="hidden md:block border-t border-gray-200 dark:border-gray-200/5 bg-gray-50 dark:bg-gray-700/40 text-sm font-medium text-gray-500 dark:text-gray-400">
            <div class="block">
                <x-content-box height="xs" class="flex">
                    <div class="min-w-0 flex-1 grid grid-cols-1 {{ $columns ? 'grid-cols-'.$columns : '' }} gap-4">
                        {{ $header }}
                    </div>
                    <div class="block ml-4 w-6"></div>
                </x-content-box>
            </div>
        </li>
    @endif

    {{ $slot }}

    @if ($emptyMessage)
        <li class="border-t border-gray-200 dark:border-gray-200/10">
            {{ $emptyMessage }}
        </li>
    @endif
</ul>

@if ($footer)
    <x-content-box height="xs" class="border-t border-gray-200 dark:border-gray-200/10">
        {{ $footer }}
    </x-content-box>
@endif
