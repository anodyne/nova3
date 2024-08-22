@use('Nova\Forms\Models\Form')
@use('Nova\Forms\Models\FormSubmission')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @can('viewAny', Form::class)
            <x-sidebar.subnav.item :href="route('admin.forms.index')" :active="request()->routeIs('admin.forms.*')">
                All forms
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', FormSubmission::class)
            <x-sidebar.subnav.item
                :href="route('admin.form-submissions.index')"
                :active="request()->routeIs('admin.form-submissions.*')"
            >
                Submissions
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
