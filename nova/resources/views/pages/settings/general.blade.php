@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="General settings">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button.outline color="primary" leading="search" x-on:click="$dispatch('toggle-spotlight')">Find a setting</x-button.outline>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="general">
            <x-form.footer>
                <x-button.filled type="submit" form="general" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
