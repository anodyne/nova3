@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Preview form &ndash; {{ $form->name }}</x-slot>

            <x-slot name="actions">
                <x-button :href="route('forms.design', $form)" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <div class="mb-8 inline-flex w-full gap-x-2 lg:w-auto">
            <a
                href="{{ route('forms.preview', [$form, 'public']) }}"
                @class([
                    'flex flex-1 justify-center whitespace-nowrap rounded-full px-4 py-2 text-base font-medium transition focus:outline-none sm:text-sm/6 lg:flex-initial lg:py-1',
                    'bg-gray-950 text-white dark:bg-gray-300 dark:text-gray-950' => $theme === 'public',
                    'text-gray-500 hover:text-gray-900 dark:hover:text-white' => $theme !== 'public',
                ])
            >
                Public theme
            </a>
            <a
                href="{{ route('forms.preview', [$form, 'admin']) }}"
                @class([
                    'flex flex-1 justify-center whitespace-nowrap rounded-full px-4 py-2 text-base font-medium transition focus:outline-none sm:text-sm/6 lg:flex-initial lg:py-1',
                    'bg-gray-950 text-white dark:bg-gray-300 dark:text-gray-950' => $theme === 'admin',
                    'text-gray-500 hover:text-gray-900 dark:hover:text-white' => $theme !== 'admin',
                ])
            >
                Admin theme
            </a>
        </div>

        @if ($theme === 'admin')
            <livewire:dynamic-form :form="$form" :admin="true" />
        @else
            <livewire:dynamic-form :form="$form" />
        @endif

        {{--
            <x-form.dynamic :admin="$theme === 'admin'">
            {!! scribble($form->fields ?? ['content' => null])->toHtml() !!}
            </x-form.dynamic>
        --}}
    </x-spacing>
@endsection
