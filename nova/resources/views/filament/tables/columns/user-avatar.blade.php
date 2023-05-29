@php
  $user = $getRecord();
@endphp

<div class="flex items-center py-4 px-6">
  <x-avatar.user :user="$user"></x-avatar.user>
</div>