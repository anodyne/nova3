@props([
    'action' => null,
    'active' => null,
    'activeOptions' => '{}',
    'icon' => null,
])

@php
    $activeArguments = collect(["'{$active}'", $activeOptions])->filter()->join(', ');
@endphp

{{-- format-ignore-start --}}
<button
    type="button"
    @class([
        'transition',
        'text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400' => blank($active) && $activeOptions === '{}',
    ])
    @if (filled($active) || $activeOptions !== '{}')
        x-bind:class="{
            'text-primary-500': window.editor.isActive({{ $activeArguments }}, updatedAt),
            'text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400': ! window.editor.isActive({{ $activeArguments }}, updatedAt),
        }"
    @endif
    @if ($action)
        x-on:click="window.editor.chain().focus().{{ $action }}.run()"
    @endif
    {{ $attributes }}
>
    <x-icon :name="$icon" size="md"></x-icon>
</button>
{{-- format-ignore-end --}}
