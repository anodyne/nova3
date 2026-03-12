@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-avatar :src="$user_avatar" size="sm" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $user_name }}</strong> has discarded the
    {{ str($post_type_name)->lower() }} draft of <em>{{ $post_title }}</em>
    {{-- format-ignore-end --}}
</x-notification>
