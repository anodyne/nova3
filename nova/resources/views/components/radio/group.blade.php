@props([
    'error' => null,
])

<div
    data-slot="control"
    {{ $attributes->merge(['class' => 'space-y-3 [&_[data-slot=label]]:font-normal has-[[data-slot=description]]:space-y-6 [&_[data-slot=label]]:has-[[data-slot=description]]:font-medium']) }}
>
    {{ $slot }}

    @if (filled($error))
        <div data-slot="error" class="flex items-center gap-x-1">
            <x-icon name="alert" size="sm" class="text-danger-400 dark:text-danger-600"></x-icon>
            <x-fieldset.error-message>{{ $error }}</x-fieldset.error-message>
        </div>
    @endif
</div>
