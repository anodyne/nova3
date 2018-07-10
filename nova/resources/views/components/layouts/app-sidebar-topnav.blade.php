<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Layout - App - Sidebar w/ Top Nav</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script>
        window.App = Object.freeze(@json(['Page' => $_page, 'Theme' => $_theme]))
    </script>
</head>
<body class="bg-grey-lighter text-grey-darkest font-sans">
    <div id="app" class="flex flex-row h-screen w-full bg-grey-lighter">
        <nav class="hidden md:flex flex-col items-stretch justify-between fixed w-72 bg-white border-r h-screen py-3 px-6 text-grey-dark leading-normal">
            <div>
                <a href="#" class="flex justify-center my-6">
                    <img src="{{ asset('images/logo.svg') }}" alt="">
                </a>

                <div class="flex flex-col -mx-6">
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="home" class="h-5 w-5 mr-3"></i>
                            Dashboard
                        </div>
                    </a>
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="file" class="h-5 w-5 mr-3"></i>
                            Pages
                        </div>
                        <i data-feather="chevron-down" class="h-4 w-4"></i>
                    </a>
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="user" class="h-5 w-5 mr-3"></i>
                            Authentication
                        </div>
                        <i data-feather="chevron-down" class="h-4 w-4"></i>
                    </a>
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="layout" class="h-5 w-5 mr-3"></i>
                            Layouts
                        </div>
                        <i data-feather="chevron-down" class="h-4 w-4"></i>
                    </a>
                </div>

                <div class="my-3 border-t"></div>

                <div class="text-xs uppercase tracking-wide py-3 text-grey font-medium">Documentation</div>

                <div class="flex flex-col -mx-6">
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="clipboard" class="h-5 w-5 mr-3"></i>
                            Getting started
                        </div>
                    </a>
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="book-open" class="h-5 w-5 mr-3"></i>
                            Components
                        </div>
                        <i data-feather="chevron-down" class="h-4 w-4"></i>
                    </a>
                    <a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
                        <div class="flex items-center">
                            <i data-feather="git-branch" class="h-5 w-5 mr-3"></i>
                            Changelog
                        </div>
                        <div class="rounded bg-blue text-white text-2xs py-1 px-2">v1.0</div>
                    </a>
                </div>
            </div>
        </nav>

        <main class="flex-1 md:ml-72">
            <div class="flex items-center justify-between bg-white border-b px-6 py-3">
                <div class="block flex-shrink md:hidden">
                    <i data-feather="menu" class="h-6 w-6 mr-3"></i>
                </div>

                <div class="text-grey-darkest text-lg font-medium">{{ config('app.name') }}</div>

                <div class="flex items-center">
                    <div class="flex items-center mr-6 rounded-full border py-3 px-6 w-72 text-grey">
                        <i data-feather="search" class="mr-2 h-5 w-5"></i>
                        <input type="text" class="w-full" placeholder="Search...">
                    </div>

                    <a href="#" class="no-underline text-grey hover:text-grey-darker leading-0 mr-6">
                        <i data-feather="bell" class="h-5 w-5"></i>
                    </a>

                    <img src="{{ asset('images/avatar-1.jpg') }}" alt="" class="rounded-full h-10 w-10">
                </div>
            </div>
            <div class="py-6 px-8">
                @yield('template')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>