{{-- format-ignore-start --}}
<x-mail::message>
# Character denied

A character associated with your account has been denied.

<x-mail::panel>
**Name:** {{ $character->name }}

**Reason:** {{ $reason }}
</x-mail::panel>
</x-mail::message>
{{-- format-ignore-end --}}
