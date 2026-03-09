@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.characters.show', $character_id)">
    <x-slot name="leading" class="text-info-500">
        <x-icon :name="NotificationIcon::UserProfile2" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $character_name }}</strong> has been created by <em>{{ $creator_name }}</em>
    and requires approval before it can be activated
    {{-- format-ignore-end --}}
</x-notification>
