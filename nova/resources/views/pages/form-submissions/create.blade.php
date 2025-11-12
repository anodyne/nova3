@use('Nova\Forms\Models\Form')
@use('Nova\Forms\Models\FormSubmission')

<x-admin-layout>
    @if (filled($form))
        <x-spacing constrained>
            <x-page-heading :heading="$form->name" description="">
                @can('viewAny', FormSubmission::class)
                    <x-slot name="actions">
                        <x-button :href="route('admin.form-submissions.index')" variant="ghost" inset="right">
                            <span aria-hidden="true">←</span>
                            Back
                        </x-button>
                    </x-slot>
                @endcan
            </x-page-heading>

            <x-fieldset>
                <x-fieldset.group constrained>
                    <livewire:dynamic-form :form="$form" :owner="auth()->user()" :admin="true" />
                </x-fieldset.group>
            </x-fieldset>
        </x-spacing>
    @else
        <div class="mx-auto max-w-lg">
            <x-page-heading></x-page-heading>

            <ul role="list" class="mt-6">
                @forelse ($forms as $f)
                    <li>
                        <div
                            class="group relative flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-900"
                        >
                            <div class="min-w-0 flex-1">
                                <p class="text-sm/6 font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('admin.form-submissions.create', $f->id) }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $f->name }}
                                    </a>
                                </p>
                                <x-text>{{ $f->description }}</x-text>
                            </div>
                            <div class="shrink-0 self-center">
                                <x-icon.chevron-right class="size-5 text-gray-400 group-hover:text-gray-500" />
                            </div>
                        </div>
                    </li>
                @empty
                    <li>
                        <x-callout.success :icon="Tabler::CircleCheck">
                            You don’t have any available forms that can be submitted
                        </x-callout.success>
                    </li>
                @endforelse
            </ul>

            @can('create', Form::class)
                <div class="mt-6">
                    <x-button :href="route('admin.forms.index')">
                        Or create a new form
                        <span aria-hidden="true">→</span>
                    </x-button>
                </div>
            @endcan
        </div>
    @endif
</x-admin-layout>
