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
    <link href="{{ asset('/themes/pulsar/design/custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('/dist/js/app-client.js') }}" defer></script>
    @routes
</head>
<body class="font-sans bg-gray-100 text-gray-900 antialiased">
    @inertia
</body>
</html>