@extends($meta->template)

@section('content')
    <x-page-header title="General Settings" />

    <x-panel on-edge>
        <x-form :action="route('settings.update')" method="PUT" id="general">
            <x-form.footer>
                <x-button type="submit" form="general" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection