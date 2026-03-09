{{-- format-ignore-start --}}
<x-email-layout>
# Discussion message received

{{ $message->content }}

<x-mail::button :url="route('admin.discussions.index')">
Go to messages <span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
