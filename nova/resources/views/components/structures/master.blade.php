<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="nova-app">
        {!! $layout ?? false !!}
    </div>

    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script>
        Nova.setConfig(Object.freeze({!! nova()->provideScriptVariables() !!}));
    </script>
    {!! $scripts ?? false !!}
    <script>
        Nova.run();
    </script>
</body>
</html>