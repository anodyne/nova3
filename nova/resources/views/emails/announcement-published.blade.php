{{-- format-ignore-start --}}
<x-email-layout>
# {{ $announcement->title }}

{!! $announcement->content !!}

*Posted in {{ $announcement->category }}*

<x-mail::button :url="route('admin.announcements.show', $announcement)">
Read now
<span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
