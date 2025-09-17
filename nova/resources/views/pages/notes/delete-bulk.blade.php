@php
    $total = $records->count();
    $additional = $total - 5;
@endphp

<x-filament.modal-content :$action>
    <x-slot name="title">Delete {{ $total }} selected {{ str('note')->plural($total) }}?</x-slot>

    <x-text>Are you sure you want to delete the following notes?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records->take(5) as $record)
            <li class="px-2 py-1">{{ $record->title }}</li>
        @endforeach

        @if ($additional > 0)
            <li class="px-2 py-1">{{ $additional }} additional {{ str('announcement')->plural($additional) }}</li>
        @endif
    </ul>

    <x-text>You won’t be able to recover {{ trans_choice('it|them', $total) }}.</x-text>
</x-filament.modal-content>
