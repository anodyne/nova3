@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-avatar :src="$user_avatar" size="xs"></x-avatar>
    </x-slot>

    {{ $user_name }} has discarded the {{ str($post_type_name)->lower() }} draft of
    <strong class="font-semibold text-gray-900 dark:text-white">{{ $post_title }}.</strong>
</x-notification>
