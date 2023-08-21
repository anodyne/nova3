@extends($meta->template)

@section('content')
    <livewire:themes-list />

    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-panel.primary icon="paint-brush">
            <div class="flex-1 md:flex md:justify-between">
                <p class="text-base md:text-sm">
                    Looking for more themes for your game? Check out the Nova Add-on Exchange!
                </p>
                <p class="mt-3 shrink-0 text-base md:ml-6 md:mt-0 md:text-sm">
                    <x-button.text :href="config('services.anodyne.links.exchange')" target="_blank" color="primary">
                        Go &rarr;
                    </x-button.text>
                </p>
            </div>
        </x-panel.primary>
    </div>
@endsection
