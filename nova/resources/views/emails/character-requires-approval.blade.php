{{-- format-ignore-start --}}
<x-email-layout>
# Pending character requires approval

**{{ $character->name }}** has been created by {{ $creatingUser->name }} and requires approval before it can be activated.

<x-mail::panel>
**Name:** {{ $character->name }}

@if ($character->positions->count() > 0)
**@choice('Position|Positions', $character->positions->count()):** {{ $character->positions->pluck('name')->join(',', ', and ') }}
@endif

@if ($character->rank)
**Rank:** {{ $character->rank?->name->name }}
@endif
</x-mail::panel>

<x-mail::button :url="route('characters.index')">
View pending characters &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
