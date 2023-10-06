@extends('layouts.setup')

@section('content')
    <livewire:setup-configure-database :is-migrating="request()->is('setup/migrate/*')" />
@endsection
