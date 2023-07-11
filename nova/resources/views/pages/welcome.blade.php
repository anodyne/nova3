<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nova NextGen</title>
        @filamentStyles
        <link rel="stylesheet" href="/dist/css/app.css" />
    </head>
    <body class="text-grey-12 bg-white font-sans leading-normal">
        <div class="mx-auto flex h-screen items-center justify-center px-2">
            <div class="pb-16 text-center">
                <a href="https://anodyne-productions.com/nova" class="mb-8 block">
                    <x-logos.nova class="mx-auto h-20 w-auto" />
                </a>
                <div class="space-x-4 text-sm font-semibold text-gray-600">
                    @auth
                        <a
                            class="rounded-full px-3 py-1 ring-1 ring-inset ring-transparent hover:bg-info-50 hover:text-info-600 hover:ring-info-500/10 hover:dark:bg-info-400/10 hover:dark:text-info-400 hover:dark:ring-info-400/20"
                            href="{{ route('dashboard') }}"
                        >
                            Dashboard
                        </a>
                    @endauth

                    @guest
                        <a
                            class="rounded-full px-3 py-1 ring-1 ring-inset ring-transparent hover:bg-info-50 hover:text-info-600 hover:ring-info-500/10 hover:dark:bg-info-400/10 hover:dark:text-info-400 hover:dark:ring-info-400/20"
                            href="{{ route('login') }}"
                        >
                            Sign In
                        </a>
                    @endguest

                    <a
                        class="rounded-full px-3 py-1 ring-1 ring-inset ring-transparent hover:bg-info-50 hover:text-info-600 hover:ring-info-500/10 hover:dark:bg-info-400/10 hover:dark:text-info-400 hover:dark:ring-info-400/20"
                        href="https://anodyne-productions.com/docs"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Documentation
                    </a>

                    <a
                        class="rounded-full px-3 py-1 ring-1 ring-inset ring-transparent hover:bg-info-50 hover:text-info-600 hover:ring-info-500/10 hover:dark:bg-info-400/10 hover:dark:text-info-400 hover:dark:ring-info-400/20"
                        href="https://anodyne-productions.com/support/chat"
                        rel="noopener noreferrer"
                    >
                        Support
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
