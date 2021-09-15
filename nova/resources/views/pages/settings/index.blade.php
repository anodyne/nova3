@extends($meta->template)

@section('content')
    <x-page-header title="Settings" />

    {{-- <x-under-construction feature="Settings">
        <li>Settings are not stored in the database yet</li>
        <li>Settings cannot be updated</li>
    </x-under-construction> --}}

    <x-panel on-edge>
        @include("pages.settings._{$tab}")
    </x-panel>

    <x-tips section="settings" />
@endsection
