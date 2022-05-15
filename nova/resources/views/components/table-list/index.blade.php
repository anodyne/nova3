@props([
    'columns' => false,
    'emptyMessage' => false,
    'footer' => false,
    'header' => false,
])

<ul class="divide-y divide-gray-100 dark:divide-gray-200/10" {{ $attributes }}>
    @if ($header)
        <x-table-list.header>
            {{ $header }}
        </x-table-list.header>
    @endif

    {{ $slot }}

    @if ($emptyMessage)
        <li class="border-t border-gray-100 dark:border-gray-200/10">
            {{ $emptyMessage }}
        </li>
    @endif
</ul>

@if ($footer)
    <x-content-box height="xs" class="border-t border-gray-100 dark:border-gray-200/10">
        {{ $footer }}
    </x-content-box>
@endif