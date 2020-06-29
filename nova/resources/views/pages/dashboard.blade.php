@extends($__novaTemplate)

@section('content')
    <x-page-header title="Dashboard" />

    <x-panel class="p-6">
        <p>Welcome to Nova 3.</p>

        <x-list-box class="mt-6" :items="Nova\Users\Models\User::get()" />
    </x-panel>

    <div class="w-full max-w-2xl mx-auto mt-16">
        <div class="rounded-md bg-purple-100 p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @icon('lightbulb', 'h-6 w-6 text-purple-500')
                </div>
                <div class="ml-3 flex-1 | md:flex md:justify-between">
                    <p class="text-sm leading-6 text-purple-700">
                        {{ config('tips')['rank.create'][0] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
