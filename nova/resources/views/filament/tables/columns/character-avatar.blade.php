@php
    $character = $getRecord();
@endphp

<div class="flex items-center gap-x-4 px-3 py-3.5">
    <x-avatar.character :character="$character"></x-avatar.character>
</div>
