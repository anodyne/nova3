{{-- format-ignore-start --}}
<x-email-layout>
# New form submission

**{{ $user?->name ?? 'A user' }}** has submitted a new {{ $form }} form.

<x-mail::panel>
@foreach ($values as $field => $value)
**{{ $field }}**: {{ $value }}

@endforeach
</x-mail::panel>
</x-email-layout>
{{-- format-ignore-end --}}
