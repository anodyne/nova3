@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Meta tags settings">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button.filled color="neutral" leading="search" x-on:click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.filled>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="meta-tags">
            <x-form.footer>
                <x-button.filled type="submit" form="meta-tags" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
