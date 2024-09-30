{{-- format-ignore-start --}}
<x-email-layout>
# {{ $announcement->title }}

{!! $announcement->content !!}

<x-mail::button :url="route('admin.announcements.show', $announcement)">
Read now &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
