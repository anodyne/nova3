{{-- format-ignore-start --}}
<x-email-layout>
# Participant left the discussion

{{ $user->name }} has left the {{ $discussion->subject }} discussion.

<x-mail::button :url="route('admin.discussions.index')">
Go to messages <span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
