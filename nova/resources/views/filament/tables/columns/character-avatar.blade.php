@php
    $character = $getRecord();
@endphp

<div class="flex items-center px-6 py-4">
    <x-avatar.character :character="$character"></x-avatar.character>
</div>
