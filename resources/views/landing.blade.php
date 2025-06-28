<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Modern Landing Page - Your Business Solution</title>
    <meta name="description"
        content="Discover our modern business solutions with flexible pricing plans. Get started today with our comprehensive services." />
    <meta name="keywords" content="business, solutions, pricing, contact, about" />
    <meta property="og:title" content="Modern Landing Page - Your Business Solution" />
    <meta property="og:description" content="Discover our modern business solutions with flexible pricing plans." />
    <meta property="og:type" content="website" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>