@extends($meta->template)

@section('content')
    <x-button.filled color="primary" leading="add">Add</x-button.filled>

    <livewire:notes-list />

    <x-tips section="notes" />
@endsection
