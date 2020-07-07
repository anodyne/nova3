@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Character">
        <x-slot name="pretitle">
            <a href="{{ route('characters.index', 'status=active') }}">Characters</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('characters.store')">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Position(s)">
                    @livewire('positions:collector')
                </x-input.group>

                <x-input.group label="Rank">
                    @livewire('ranks:dropdown')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar" message="Character avatars should be a square image at least 200 pixels tall by 200 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('characters:upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Users">
                Coming soon...
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Character</button>

                <a href="{{ route('characters.index', 'status=active') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
