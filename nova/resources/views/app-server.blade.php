<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    <!-- Styles -->
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">
    <link href="{{ asset('/dist/css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.novaToast = @json(session('nova.toast', []));
        window.novaSettings = @json(nova()->provideScriptVariables());
    </script>
    <script src="{{ asset('/dist/js/app-server.js') }}" defer></script>
    @routes
</head>
<body class="font-sans bg-gray-200 text-gray-900 antialiased">
    <div id="app">
        {!! $layout ?? false !!}

        <toaster-oven></toaster-oven>
    </div>

    {!! $scripts ?? false !!}
</body>
</html>