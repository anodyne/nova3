@extends($meta->template)

@section('content')
    <x-page-header title="Meta Tags Settings" x-data="{}">
        <x-slot:controls>
            <x-button type="button" color="white" size="sm" @click="$dispatch('toggle-spotlight')">
                @icon('search', 'h-5 w-5')
                <span class="ml-2">Find a setting</span>
            </x-button>
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form :action="route('settings.update')" method="PUT" id="meta-tags">
            <x-form.footer>
                <x-button type="submit" form="meta-tags" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
