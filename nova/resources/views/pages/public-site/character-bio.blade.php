@extends($meta->template)

@section('content')
    <div class="@container nova-advanced-page-content">
        <div class="flex gap-16">
            <div class="shrink-0">
                <x-avatar :src="$character->avatar_url" size="3xl"></x-avatar>
            </div>

            <div class="flex-1 space-y-8">
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-x-8">
                        <x-public::h1>{{ $character->name }}</x-public::h1>
                        <div>
                            <x-rank :rank="$character->rank"></x-rank>
                        </div>
                    </div>

                    <div class="flex items-center gap-x-4">
                        <div class="text-lg/7 font-semibold text-gray-500">
                            {{ $character->rank->name->name }}
                        </div>

                        <div class="text-lg/7 text-gray-300">/</div>

                        <div class="text-lg/7 font-semibold text-gray-500">
                            {{ $character->positions->implode('name', ' & ') }}
                        </div>
                    </div>
                </div>

                <div class="h-px max-w-lg bg-gradient-to-r from-gray-200 to-transparent"></div>

                <div>
                    <livewire:dynamic-form
                        :form="$form"
                        :submission="$character->characterFormSubmission"
                        :static="true"
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
