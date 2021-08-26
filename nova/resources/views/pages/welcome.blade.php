<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nova NextGen</title>
    <link rel="stylesheet" href="/dist/css/app.css">
</head>
<body class="bg-gray-100 font-sans leading-normal text-grey-800">
    <div class="mx-auto px-2 h-screen flex items-center justify-center">
        <div class="pb-16 text-center">
            <a href="https://anodyne-productions.com/nova" class="block mb-8">
                <x-nova-logo class="text-blue-9 h-24 w-auto mx-auto" />
            </a>
            <div class="text-xs font-bold uppercase tracking-wide text-gray-500 space-x-4">
                @auth
                    <a class="hover:bg-gray-200 p-2 rounded" href="{{ route('dashboard') }}">Dashboard</a>
                @endauth

                @guest
                    <a class="hover:bg-gray-200 p-2 rounded" href="{{ route('login') }}">Sign In</a>
                @endguest

                <a class="hover:bg-gray-200 p-2 rounded" href="https://anodyne-productions.com/docs" target="_blank" rel="noopener noreferrer">Documentation</a>
                <a class="hover:bg-gray-200 p-2 rounded" href="https://anodyne-productions.com/support/chat" rel="noopener noreferrer">Support</a>
            </div>
        </div>
    </div>
</body>
</html>
