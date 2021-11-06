@extends($meta->template)

@section('content')
    <x-page-header title="General Settings" x-data="{}">
        <x-slot name="controls">
            <x-button type="button" color="white" size="sm" @click="$dispatch('toggle-spotlight')">
                @icon('search', 'h-5 w-5')
                <span class="ml-2">Find a setting</span>
            </x-button>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('settings.update')" method="PUT" id="general">
            <x-form.footer>
                <x-button type="submit" form="general" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection