@if ($stories->count() > 0)
    <div>
        <x-public::stories.timeline :$stories :expanded="true"></x-public::stories.timeline>
    </div>
@else
    <div>No stories</div>
@endif
