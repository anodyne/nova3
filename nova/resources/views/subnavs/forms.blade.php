@use('Nova\Forms\Models\Form')
@use('Nova\Forms\Models\FormSubmission')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @can('viewAny', Form::class)
            <x-sidebar.subnav.item href="{{ route('forms.index') }}" :active="request()->routeIs('forms.*')">
                All forms
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', FormSubmission::class)
            <x-sidebar.subnav.item
                href="{{ route('form-submissions.index') }}"
                :active="request()->routeIs('form-submissions.*')"
            >
                Submissions
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
