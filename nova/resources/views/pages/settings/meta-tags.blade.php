@extends($meta->template)

@section('content')
    <x-page-header title="Meta Tags Settings">
        <x-slot name="controls">
            <x-button color="white" size="sm" onclick="Livewire.emit('openModal', 'settings:find-settings')">
                @icon('search', 'h-5 w-5')
                <span class="ml-2">Find a setting</span>
            </x-button>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('settings.update')" method="PUT" id="meta-tags">
            <x-form.footer>
                <x-button type="submit" form="meta-tags" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection