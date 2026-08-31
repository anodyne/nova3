@php
    $user = $getRecord();
@endphp

<div class="flex items-center px-3 py-2.5">
    <x-avatar.user :$user pronouns></x-avatar.user>
</div>
