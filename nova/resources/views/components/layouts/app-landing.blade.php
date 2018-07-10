<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Layouts - App - Landing</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-grey-lighter text-grey-darkest font-sans">
    <div id="app">
        <header class="h-128 bg-cover bg-no-repeat bg-center bg-transparent" style="background-image:url(/images/maelstrom_ii_m2.jpg)"></header>

        <div class="container mx-auto">
            <nav class="bg-white border rounded py-4 px-8 text-grey-dark leading-normal -mt-9">
                <div class="flex items-center justify-between">
                    <div class="flex-1 text-sm">
                        <a href="#" class="inline-flex no-underline text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
                            Dashboard
                        </a>
                        <a href="#" class="inline-flex no-underline text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
                            Pages
                            <i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
                        </a>
                        <a href="#" class="inline-flex no-underline text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
                            Authentication
                            <i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
                        </a>
                        <a href="#" class="inline-flex no-underline text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
                            Layouts
                            <i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
                        </a>
                        <a href="#" class="inline-flex no-underline text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
                            Docs
                            <i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
                        </a>
                    </div>

                    {{-- <div class="flex-shrink">
                        <img src="{{ asset('images/logo.svg') }}" alt="" class="h-10 w-10 leading-0">
                    </div> --}}

                    <div class="flex-1 flex justify-end">
                        <div class="flex items-center">
                            <a href="#" class="no-underline text-grey hover:text-grey-darker leading-0 mr-6">
                                <i data-feather="search" class="h-5 w-5"></i>
                            </a>

                            <a href="#" class="no-underline text-grey hover:text-grey-darker leading-0 mr-6">
                                <i data-feather="bell" class="h-5 w-5"></i>
                            </a>

                            <img src="{{ asset('images/avatar-1.jpg') }}" alt="" class="rounded-full h-10 w-10">
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container mx-auto my-12">
            <main>
                @component('components.page-header')
                    @slot('pretitle', $_theme->name)

                    @slot('title', $_page->name)

                    @slot('aside')
                        <a href="#" class="rounded py-3 px-4 bg-blue text-white font-medium no-underline text-sm hover:bg-blue-dark">Create Report</a>
                    @endslot
                @endcomponent

                @yield('template')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>