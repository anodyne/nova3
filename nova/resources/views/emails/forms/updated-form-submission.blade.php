{{-- format-ignore-start --}}
<x-email-layout>
# Updated form submission

**{{ $user?->name ?? 'A user' }}** has updated their {{ $form }} form submission.

<x-mail::panel>
@foreach ($values as $field => $value)
**{{ $field }}**: {{ $value }}

@endforeach
</x-mail::panel>
</x-email-layout>
{{-- format-ignore-end --}}
