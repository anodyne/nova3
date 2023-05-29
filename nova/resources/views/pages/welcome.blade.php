<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nova NextGen</title>
    <x-admin-theme :settings="settings()" />
    <link rel="stylesheet" href="/dist/css/app.css">
</head>
<body class="bg-white font-sans leading-normal text-grey-12">
    <div class="mx-auto px-2 h-screen flex items-center justify-center">
        <div class="pb-16 text-center">
            <a href="https://anodyne-productions.com/nova" class="block mb-8">
                <x-logos.nova class="h-20 w-auto mx-auto" />
            </a>
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-600 space-x-4">
                @auth
                    <a class="border border-transparent hover:bg-secondary-50 hover:border-secondary-300 hover:text-secondary-500 px-3 py-1 rounded-full" href="{{ route('dashboard') }}">Dashboard</a>
                @endauth

                @guest
                    <a class="border border-transparent hover:bg-secondary-50 hover:border-secondary-300 hover:text-secondary-500 px-3 py-1 rounded-full" href="{{ route('login') }}">Sign In</a>
                @endguest

                <a class="border border-transparent hover:bg-secondary-50 hover:border-secondary-300 hover:text-secondary-500 px-3 py-1 rounded-full" href="https://anodyne-productions.com/docs" target="_blank" rel="noopener noreferrer">Documentation</a>

                <a class="border border-transparent hover:bg-secondary-50 hover:border-secondary-300 hover:text-secondary-500 px-3 py-1 rounded-full" href="https://anodyne-productions.com/support/chat" rel="noopener noreferrer">Support</a>
            </div>
        </div>
    </div>
</body>
</html>
