@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="General settings">
            <x-slot:controls>
                <div x-data="{}">
                    <x-button color="primary-outline" @click="$dispatch('toggle-spotlight')" leading="search">
                        Find a setting
                    </x-button>
                </div>
            </x-slot:controls>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="general">
            <x-form.footer>
                <x-button type="submit" form="general" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
