@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-icon :name="Icon::ProgressXmark" size="xl"></x-icon>
    </x-slot>

    {{-- format-ignore-start --}}
    {{ $reviewer_name }} has voted to deny the application for
    <strong class="font-semibold text-gray-900 dark:text-white">{{ $character_name }}</strong>.
    {{-- format-ignore-end --}}

    <x-slot name="actions">
        <x-button :href="route('admin.applications.show', $application_id)" color="primary">
            View application &rarr;
        </x-button>
    </x-slot>
</x-notification>
