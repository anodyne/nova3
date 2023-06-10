@php
    $user = $getRecord();
@endphp

<div class="flex items-center px-6 py-4">
    <x-avatar.user :user="$user" secondary-pronouns></x-avatar.user>
</div>
