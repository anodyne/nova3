@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$form->name" />

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
                @can('update', $form)
                    <x-button-filled tag="a" :href="route('forms.edit', $form)" leading="edit">Edit</x-button-filled>
                    <x-button-outline tag="a" :href="route('forms.edit', $form)" leading="wrench">Design</x-button-outline>
                @endcan

                @can('viewAny', $form::class)
                    <x-link :href="route('forms.index')" color="gray" leading="arrow-left">Back to the forms list</x-link>
                @endcan
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
