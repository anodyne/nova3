{{-- format-ignore-start --}}
<x-mail::message>
# Pending character requires approval

A new charcter has been created by {{ $creatingUser->name }} that requires approval. Please sign in to review the pending character.

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
View pending characters
</x-mail::button>
</x-mail::message>
{{-- format-ignore-end --}}
