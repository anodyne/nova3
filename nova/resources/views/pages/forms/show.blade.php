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
                    <x-button.filled :href="route('forms.edit', $form)" leading="edit" color="primary">
                        Edit
                    </x-button.filled>
                    <x-button.outlined :href="route('forms.edit', $form)" leading="tools" color="primary">
                        Design
                    </x-button.outlined>
                @endcan

                @can('viewAny', $form::class)
                    <x-button.text :href="route('forms.index')" color="gray" leading="arrow-left">Back</x-button.text>
                @endcan
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
