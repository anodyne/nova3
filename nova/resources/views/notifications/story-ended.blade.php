@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.stories.show', $story_id)">
    <x-slot name="leading" class="text-success-500">
        <x-icon :name="NotificationIcon::BookClosed" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $story_title }}</strong> has been marked as completed
    {{-- format-ignore-end --}}
</x-notification>
