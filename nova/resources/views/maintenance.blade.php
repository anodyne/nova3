<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('title')</title>
        <link href="/dist/fonts/geist/font.css" rel="stylesheet" />
        <link href="/dist/fonts/inter/font.css" rel="stylesheet" />
        <link href="/dist/css/maintenance.css" rel="stylesheet" />
    </head>
    <body class="bg-white font-sans antialiased dark:bg-black">
        <div class="relative flex min-h-screen items-center justify-center">
            <div class="mx-auto flex h-full max-w-4xl flex-col gap-8 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <img src="/dist/images/shuttle-light.webp" alt="" class="block w-full dark:hidden" />
                    <img src="/dist/images/shuttle-dark.webp" alt="" class="hidden w-full dark:block" />
                </div>

                <div class="space-y-1 text-center">
                    <div class="font-title text-4xl font-bold text-gray-950 dark:text-white">
                        We’re doing a little maintenance
                    </div>
                    <div class="text-pretty text-lg text-gray-500 dark:text-gray-400">
                        Our site is undergoing some maintenance right now. Please check back later.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
