@php
  $character = $getRecord();
@endphp

<div class="flex items-center py-4 px-6">
  <x-avatar.character :character="$character"></x-avatar.character>
</div>