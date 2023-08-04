<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    @yield('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} | {{ config('app.name') }}</title>
    {{--    <link rel='icon' href='/favicon.ico' type='image/x-icon' />--}}
    {{--    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">--}}
    {{--    <link rel="manifest" href="/manifest.json">--}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body data-route="{{ Route::currentRouteName() }}">

<main id="main_section">
    {{--        @include('storefront.components.flash-message')--}}
    @yield('page')
</main>

@stack('scripts')
</body>

</html>
