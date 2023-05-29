@php
  $rank = $getRecord();
@endphp

<div class="flex items-center space-x-3 px-6">
  <x-rank :rank="$rank"></x-rank>
  <span class="font-medium">{{ $rank->rank_name }}</span>
</div>