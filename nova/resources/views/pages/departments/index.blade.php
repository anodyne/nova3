@extends($meta->template)

@section('content')
    <x-page-header title="Departments" x-data="{}">
        <x-slot:controls>
            @if ($departmentCount > 0)
                @can('create', $department)
                    <x-link :href="route('departments.create')" color="primary" data-cy="create">
                        Add Department
                    </x-link>
                @endcan
            @endif
        </x-slot:controls>
    </x-page-header>

    @if ($departmentCount === 0)
        <x-empty-state.large
            image="organizer"
            message="Departments allow you to organize character positions into logical groups that you can display on your manifests."
            label="Add a deparment now"
            :link="route('departments.create')"
            :link-access="gate()->allows('create', $department)"
        ></x-empty-state.large>
    @else
        @livewire('departments:list')

        <x-tips section="departments" />

        <x-modal color="error" title="Delete Department?" icon="warning" :url="route('departments.delete')">
            <x-slot:footer>
                <span class="flex w-full sm:col-start-2">
                    <x-button type="submit" form="form" color="error" full-width>
                        Delete
                    </x-button>
                </span>
                <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                    <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                        Cancel
                    </x-button>
                </span>
            </x-slot:footer>
        </x-modal>

        <x-modal color="primary" title="Duplicate department" icon="copy" :url="route('departments.confirm-duplicate')" event="modal-duplicate" :wide="true">
            <x-slot:footer>
                <span class="flex w-full sm:col-start-2">
                    <x-button type="submit" form="form-duplicate" color="primary" full-width>
                        Duplicate
                    </x-button>
                </span>
                <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                    <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                        Cancel
                    </x-button>
                </span>
            </x-slot:footer>
        </x-modal>
    @endif
@endsection
