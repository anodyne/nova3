{{-- format-ignore-start --}}
<x-mail::message>
# Character approved

A character associated with your account has been approved.

<x-mail::panel>
**Name:** {{ $character->name }}

@if ($character->positions->count() > 0)
**@choice('Position|Positions', $character->positions->count()):** {{ $character->positions->pluck('name')->join(',', ', and ') }}
@endif

@if ($character->rank)
**Rank:** {{ $character->rank?->name->name }}
@endif
</x-mail::panel>
</x-mail::message>
{{-- format-ignore-end --}}
