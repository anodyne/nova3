@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$form->name" />

        <x-form action="" :space="false">
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
                    <x-button :href="route('forms.edit', $form)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                    <x-button :href="route('forms.edit', $form)" color="neutral">
                        <x-icon name="tools" size="sm"></x-icon>
                        Design
                    </x-button>
                @endcan

                @can('viewAny', $form::class)
                    <x-button :href="route('forms.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
