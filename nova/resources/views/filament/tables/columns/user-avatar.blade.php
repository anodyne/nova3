@php
    $user = $getRecord();
@endphp

<div class="flex items-center px-3 py-3.5">
    <x-avatar.user :user="$user" secondary-pronouns></x-avatar.user>
</div>
