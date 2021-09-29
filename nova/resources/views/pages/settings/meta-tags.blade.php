@extends($meta->template)

@section('content')
    <x-page-header title="Meta Tags Settings" />

    <x-panel>
        <x-form :action="route('settings.update')" method="PUT" id="meta-tags">
            <x-form.footer>
                <x-button type="submit" form="meta-tags" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection