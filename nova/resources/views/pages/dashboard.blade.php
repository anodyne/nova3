@extends($__novaTemplate)

@section('content')
    <header class="space-y-2">
        <p class="text-base font-medium text-gray-500">Season 1 - Into the Deep</p>

        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight | sm:text-4xl md:text-5xl">Frontier Medicine</h1>

        <div class="flex items-center space-x-8 text-gray-600 text-lg font-medium">
            <div class="flex items-center space-x-2">
                @icon('clock', 'h-6 w-6 text-gray-500')
                <span>6 Months Previous</span>
            </div>

            <div class="flex items-center space-x-2">
                @icon('location', 'h-6 w-6 text-gray-500')
                <span>Federation Medical Corps Aid Station - Yuil XI</span>
            </div>
        </div>
    </header>

    <div class="prose max-w-none pt-10">
        <p>The sandstorm was blowing hard across the surface. It stung his face and hands despite the coverings he had in place as he trudged quickly through the camp and out buildings towards the main administrators tent at the far end, tucked into the relative shelter of a cliff facing. For the most part the cliff kept that tend from the majority of the sandstorms but when it came in from the East as it was now, it didn’t help at all.</p>

        <p>The entire planet was one big dustbowl, dotted with low mountains, deep canyons and covered in sand. They said that the planet was once a lush, ocean world, some millennia ago but for as far as Federation records showed the planet had always been a wasteland. Two decades ago the Federation had attempted to colonize the planet and begin the terraforming process, but for some unspecified reason they’d abandoned the attempt. The majority of the scientists and engineers had left he planet but a few dozen families had remained; either too stubborn to leave or with nowhere else to go. They’d been suffering here ever since, trying to eek out an existence on this dustbowl.</p>
    </div>

    <div class="mt-12 rounded-md bg-gray-200 p-6">
        <h3 class="font-semibold uppercase tracking-wide text-sm text-gray-600 mb-6">Authors</h3>

        <div class="grid gap-6 | md:grid-cols-2">
            <x-avatar-meta :src="auth()->user()->avatar_url">
                <x-slot name="primaryMeta">Lieutenant Commander Alwyn Llwyd</x-slot>
                <x-slot name="secondaryMeta">Assistant Chief Medical Officer</x-slot>
            </x-avatar-meta>

            <x-avatar-meta :src="auth()->user()->avatar_url">
                <x-slot name="primaryMeta">Captain Edward Drake</x-slot>
                <x-slot name="secondaryMeta">Executive Officer</x-slot>
            </x-avatar-meta>

            <x-avatar-meta :src="auth()->user()->avatar_url">
                <x-slot name="primaryMeta">Lieutenant Colonel Aaron Drake</x-slot>
                <x-slot name="secondaryMeta">Marine Commanding Officer</x-slot>
            </x-avatar-meta>
        </div>

        <h3 class="font-semibold uppercase tracking-wide text-sm text-gray-600 my-6">Additional Contributors</h3>

        <div class="grid grid-cols-2 gap-6">
            <x-avatar-meta :src="auth()->user()->avatar_url" primary-meta="Jack Sparrow" />
        </div>
    </div>

    <div class="mt-6 text-center text-gray-600 space-x-8">
        <a href="#">&larr; &ldquo;Medical Mob&rdquo;</a>
        <a href="#">&ldquo;Brass Pillars&rdquo; &rarr;</a>
    </div>
@endsection
