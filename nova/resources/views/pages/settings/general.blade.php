@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="General settings">
            <x-slot:actions>
                <div x-data="{}">
                    <x-button-outline leading="search" @click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button-outline>
                </div>
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="general">
            <x-form.footer>
                <x-button-filled type="submit" form="general">Save settings</x-button-filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
