@extends($meta->structure)

@section('layout')
    <div class="h-screen flex flex-col overflow-hidden bg-gray-100">
        <header class="relative shadow bg-gray-1 mb-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-3 sm:px-6 md:px-8">
                <div class="flex flex-col">
                    @yield('writing.leading')
                </div>

                <div class="flex items-center space-x-4">
                    @yield('writing.trailing')
                </div>
            </div>
        </header>

        <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            @yield('template')
        </main>
    </div>
@endsection
