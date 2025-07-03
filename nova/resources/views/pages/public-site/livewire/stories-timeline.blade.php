<div>
    @if ($stories->count() > 0)
        <x-public::stories.timeline :$stories :expanded="true" :dot-mask="$bgColor"></x-public::stories.timeline>
    @else
        No stories
    @endif
</div>
