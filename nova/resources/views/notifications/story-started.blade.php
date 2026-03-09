@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.posts.create')">
    <x-slot name="leading" class="text-success-500">
        <x-icon :name="NotificationIcon::BookOpen" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $story_title }}</strong> has been started and is now available to post into
    {{-- format-ignore-end --}}
</x-notification>
