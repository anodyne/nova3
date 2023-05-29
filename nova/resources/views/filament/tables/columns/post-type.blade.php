@php
  $postType = $getRecord();
@endphp

<div class="flex items-center space-x-3 px-6">
  <div class="shrink-0 mt-0.5" style="color:{{ $postType->color }}">
    @isset($postType->icon)
      <x-icon :name="$postType->icon" size="md"></x-icon>
    @else
      <div class="h-6 w-6"></div>
    @endisset
  </div>

  <div class="font-medium">
    {{ $postType->name }}
  </div>
</div>