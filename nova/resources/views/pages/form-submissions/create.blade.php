@extends($meta->template)

@use('Nova\Forms\Models\FormSubmission')

@section('content')
    @if (filled($form))
        <x-spacing constrained>
            <x-page-header>
                <x-slot name="heading">{{ $form->name }}</x-slot>

                <x-slot name="actions">
                    @can('viewAny', FormSubmission::class)
                        <x-button :href="route('form-submissions.index')" plain>&larr; Back</x-button>
                    @endcan
                </x-slot>
            </x-page-header>

            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <livewire:dynamic-form :form="$form" :owner="auth()->user()" :admin="true" />
                </x-fieldset.field-group>
            </x-fieldset>
        </x-spacing>
    @else
        <div class="mx-auto max-w-lg">
            <x-page-header>
                <x-slot name="heading">Submit a form</x-slot>
                <x-slot name="description">Get started by picking a form to submit</x-slot>
            </x-page-header>

            <ul
                role="list"
                class="mt-6 divide-y divide-gray-950/5 border-b border-t border-gray-950/5 dark:divide-white/5 dark:border-white/5"
            >
                @forelse ($forms as $f)
                    <li>
                        <div class="group relative flex items-center space-x-3 py-4">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm/6 font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('form-submissions.create', $f->id) }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $f->name }}
                                    </a>
                                </p>
                                <x-text>{{ $f->description }}</x-text>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <svg
                                    class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </div>
                    </li>
                @empty
                    <li>
                        <div class="group relative flex items-center space-x-3 py-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-success-500"
                                >
                                    <x-icon name="check" class="text-white"></x-icon>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900">
                                    You don’t have any available forms that can be submitted
                                </div>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>

            @can('create', Form::class)
                <div class="mt-6 flex">
                    <x-button :href="route('forms.index')" color="primary" text>
                        Or create a new form
                        <span aria-hidden="true">&rarr;</span>
                    </x-button>
                </div>
            @endcan
        </div>
    @endif
@endsection
