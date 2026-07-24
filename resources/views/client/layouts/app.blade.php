<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini Shop')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<x-client.toast />

@include('client._partials.header')
@include('client._partials.navbar')

<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

@include('client._partials.footer')

@stack('scripts')
</body>
</html>