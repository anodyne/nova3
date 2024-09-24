{{-- format-ignore-start --}}
<x-email-layout>
# Discussion message received

{{ $message->content }}

<x-mail::button :url="route('admin.discussions.index')">
Go to messages &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
