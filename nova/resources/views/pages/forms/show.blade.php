@extends($meta->template)

@section('content')
    <x-page-header :title="$form->name">
        <x-slot:pretitle>
            <a href="{{ route('forms.index') }}">Forms</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $form)
                <x-link :href="route('forms.edit', $form)" color="primary-outline">Design Form</x-link>
                <x-link :href="route('forms.edit', $form)" color="primary">Edit Form</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="" :divide="false" :space="false">
            <x-form.section title="Form Info" message="Ad in nostrud nostrud laboris in qui aliquip velit.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $form->name }}</p>
                </x-input.group>

                <x-input.group label="Key">
                    <p class="font-semibold">{{ $form->key }}</p>
                </x-input.group>

                @if ($form->description)
                    <x-input.group label="Description">
                        <p class="font-semibold">{{ $form->description }}</p>
                    </x-input.group>
                @endif
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-link :href="route('forms.index')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
