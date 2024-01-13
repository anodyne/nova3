@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Meta tags settings">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" plain>
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT">
            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-panel>
@endsection
