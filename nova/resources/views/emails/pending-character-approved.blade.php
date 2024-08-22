{{-- format-ignore-start --}}
<x-email-layout>
# Pending character approved

Your newly created character **{{ $character->name }}** has been approved by the game masters and is now available on your account.

<x-mail::panel>
**Name:** {{ $character->name }}

@if ($character->positions->count() > 0)
**@choice('Position|Positions', $character->positions->count()):** {{ $character->positions->pluck('name')->join(',', ', and ') }}
@endif

@if ($character->rank)
**Rank:** {{ $character->rank?->name->name }}
@endif
</x-mail::panel>

<x-mail::button :href="route('admin.characters.show', $character)">View bio &rarr;</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
