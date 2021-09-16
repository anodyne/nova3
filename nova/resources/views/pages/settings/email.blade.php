@extends($meta->template)

@section('content')
    <x-page-header title="Email Settings" />

    <x-panel on-edge>
        <x-form :action="route('settings.update')" method="PUT" id="email">
            <x-form.footer>
                <x-button type="submit" form="email" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection