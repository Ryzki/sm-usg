<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>

    <!-- CSS files -->
    <link href="/assets/tabler/dist/css/tabler.min.css" rel="stylesheet" />
    <link href="/assets/tabler/dist/css/tabler-vendors.min.css" rel="stylesheet" />
    <link href="/assets/tabler/dist/css/demo.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/main/css/style.css">

    @stack('styles')
</head>

<body>
    <script src="/assets/tabler/dist/js/demo-theme.min.js"></script>
    <div class="page">
        <!-- Navbar -->
        @include('layouts.app.partials.header')
        @include('layouts.app.partials.navbar')
        <div class="page-wrapper">

            <!-- Page content -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.app.partials.footer')
        </div>
    </div>
    <!-- Tabler Core -->
    <script src="/assets/tabler/dist/js/tabler.min.js" defer></script>
    <script src="/assets/tabler/dist/js/demo.min.js" defer></script>

    <!-- Libs JS -->
    <script src="/assets/main/js/libs/jquery-3.7.1.min.js"></script>

    <!-- Main JS -->
    <script src="/assets/main/js/function.js"></script>

    @stack('script')
</body>

</html>
