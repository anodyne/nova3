<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nova NextGen</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/dist/css/app.css">
    </head>
    <body class="bg-gray-900 text-gray-500 antialiased h-screen font-sans font-thin">
        <div class="flex items-center justify-center h-screen relative">
            @if (Route::has('login'))
                <div class="absolute top-0 right-0 mt-3 mr-3">
                    @auth
                        <a href="{{ url('/home') }}" class="text-gray-500 transition-fast transition-all ease-in-out hover:text-gray-300 uppercase tracking-widest text-sm no-underline px-6 font-semibold">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 transition-fast transition-all ease-in-out hover:text-gray-300 uppercase tracking-widest text-sm no-underline px-6 font-semibold">Log In</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-500 transition-fast transition-all ease-in-out hover:text-gray-300 uppercase tracking-widest text-sm no-underline px-6 font-semibold">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="text-center">
                <div class="text-6xl text-warning-500 mb-8">
                    Nova NextGen
                </div>

                <div class="links">
                    <a href="https://anodyne-productions.com" class="text-gray-500 transition-fast transition-all ease-in-out hover:text-gray-300 uppercase tracking-widest text-sm no-underline px-6 font-semibold">Anodyne</a>
                    <a href="https://github.com/anodyne/nova3" class="text-gray-500 transition-fast transition-all ease-in-out hover:text-gray-300 uppercase tracking-widest text-sm no-underline px-6 font-semibold">GitHub</a>
                    <a href="https://github.com/anodyne/nova3/issues" class="text-gray-500 transition-fast transition-all ease-in-out hover:text-gray-300 uppercase tracking-widest text-sm no-underline px-6 font-semibold">Issues</a>
                </div>
            </div>
        </div>
    </body>
</html>