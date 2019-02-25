<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/dist/css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('/dist/js/app.js') }}" defer></script>

    <meta name="turbolinks-cache-control" content="no-cache">

    @routes
</head>
<body>
    <div
        id="nova-app"
        data-component="{{ $name }}"
        data-props="{{ json_encode($data) }}"
    ></div>
</body>
</html>