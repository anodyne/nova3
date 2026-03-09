@props([
    'tabs',
])

<flux:tab.group {{ $attributes }}>
    <flux:tabs
        class="group inline-flex h-auto gap-0.5! rounded-lg border-none bg-gray-50 ring-1 ring-gray-200 ring-inset dark:bg-gray-950 dark:ring-gray-800"
    >
        {{ $tabs }}
    </flux:tabs>

    {{ $slot }}
</flux:tab.group>
