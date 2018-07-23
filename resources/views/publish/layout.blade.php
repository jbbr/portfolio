<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.favicon')
    <title>Continuing | @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="@yield('body-class')">
<div class="ui very wide right sidebar">
    <div class="ui active inverted dimmer">
        <div class="ui medium text loader">Hilfe wird geladen</div>
    </div>
</div>
<div class="pusher">
    <div class="header">
        @include('partials.branding')
    </div>

    <div class="content-wrapper">
        <div class="content ui container @yield('content-width')">
            @yield('content')
        </div>
    </div>
    @include('partials.footer')
</div>
</body>
</html>
