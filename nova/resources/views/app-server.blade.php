<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/dist/css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.novaAlerts = @json(session('nova.alert', []));
        window.novaSettings = @json(nova()->provideScriptVariables());
    </script>
    <script src="{{ asset('/dist/js/app-server.js') }}" defer></script>
    @routes
</head>
<body>
    <div id="nova-app">
        {!! $layout ?? false !!}

        <alerts-manager :session="{{ json_encode(session('nova.alert')) }}"></alerts-manager>
    </div>

    {!! $scripts ?? false !!}
</body>
</html>