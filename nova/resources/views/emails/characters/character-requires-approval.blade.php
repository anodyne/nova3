@component('mail::message')
A new charcter has been created by {{ $creatingUser->name }} that requires approval. Please sign in to review the pending character.

Name: {{ $character->name }}
Position: {{ $character->position->name }}
Rank: {{ $character->rank->name->name }}

@component('mail::button', ['url' => ''])
View Pending Characters
@endcomponent

@endcomponent
