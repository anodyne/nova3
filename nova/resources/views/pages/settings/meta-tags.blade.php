@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Meta tags settings">
            <x-slot:actions>
                <div x-data="{}">
                    <x-button-outline leading="search" @click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button-outline>
                </div>
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="meta-tags">
            <x-form.footer>
                <x-button-filled type="submit" form="meta-tags">Save settings</x-button-filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
