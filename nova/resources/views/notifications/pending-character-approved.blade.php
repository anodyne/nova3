@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.characters.show', $character_id)">
    <x-slot name="leading" class="text-success-500">
        <x-icon :name="NotificationIcon::ThumbsUp" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    Your newly created character <strong>{{ $character_name }}</strong>
    has been approved by the game masters and is now available on your account
    {{-- format-ignore-end --}}
</x-notification>
