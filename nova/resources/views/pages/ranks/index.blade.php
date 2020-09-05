@extends($__novaTemplate)

@section('content')
    <x-page-header title="Ranks" />

    <div class="mt-12 lg:grid lg:grid-cols-3 lg:gap-8">
        <x-card>
            <div class="flex items-center justify-between">
                <h3 class="inline-flex items-center text-xl font-semibold text-gray-900">
                    Rank Groups
                </h3>
            </div>
            <p class="mt-2 text-base text-gray-500">
                Rank groups are a simple way to collect related rank items together for simpler searching and selecting.
            </p>

            <x-slot name="footer">
                <x-button-link :href="route('ranks.groups.index')" color="white" full-width>
                    Go to rank groups
                </x-button-link>
            </x-slot>
        </x-card>

        <x-card>
            <div class="flex items-center justify-between">
                <h3 class="inline-flex items-center text-xl font-semibold text-gray-900">
                    Rank Names
                </h3>
            </div>
            <p class="mt-2 text-base text-gray-500">
                Rank names eliminate the repetitive task of setting the name of a rank by letting you re-use names across rank items.
            </p>

            <x-slot name="footer">
                <x-button-link :href="route('ranks.names.index')" color="white" full-width>
                    Go to rank names
                </x-button-link>
            </x-slot>
        </x-card>

        <x-card>
            <h3 class="inline-flex items-center text-xl font-semibold text-gray-900">
                Rank Items
            </h3>
            <p class="mt-2 text-base text-gray-500">
                Rank items bring the group, name, and images together in a simple and easy-to-use rank experience.
            </p>

            <x-slot name="footer">
                <x-button-link :href="route('ranks.items.index')" color="white" full-width>
                    Go to rank items
                </x-button-link>
            </x-slot>
        </x-card>
    </div>

    <div class="w-full max-w-2xl mx-auto mt-16">
        <div class="rounded-md bg-blue-100 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @icon('info', 'h-6 w-6 text-blue-500')
                </div>
                <div class="ml-3 flex-1 | md:flex md:justify-between">
                    <p class="text-sm text-blue-700">
                        Looking for more ranks? Check out AnodyneXtras!
                    </p>
                    <p class="mt-3 text-sm | md:mt-0 md:ml-6">
                        <a href="{{ config('services.anodyne.links.xtras') }}" target="_blank" class="whitespace-no-wrap font-medium text-blue-700 hover:text-blue-600 transition ease-in-out duration-150">
                            Go &rarr;
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
