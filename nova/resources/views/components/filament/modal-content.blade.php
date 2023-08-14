@props([
    'icon' => null,
    'title',
])

{{-- format-ignore-start --}}
<div class="flex flex-col gap-6">
    <div class="flex items-center gap-3">
        @if ($icon)
            <x-icon :name="$icon" size="lg" class="text-gray-500"></x-icon>
        @endif
        <x-h2>{{ $title }}</x-h2>
    </div>
    <div class="flex flex-col gap-4">
        {{ $slot }}
    </div>
</div>
{{-- format-ignore-end --}}
