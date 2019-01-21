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
    <link href="{{ asset('dist/css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="nova-app">
        {!! $layout ?? false !!}

        <app-alert :session="{{ json_encode(session('alert')) }}"></app-alert>
    </div>

    <script src="{{ asset('dist/js/manifest.js') }}"></script>
    <script src="{{ asset('dist/js/vendor.js') }}"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script>
        Nova.setConfig({!! nova()->provideScriptVariables() !!});
    </script>
    {!! $scripts ?? false !!}
    <script>
        Nova.setFormErrors({!! $errors->toJson() !!});
        Nova.run();
    </script>
</body>
</html>