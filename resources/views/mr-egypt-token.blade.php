<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MR Egypt Token - LAST CHANCE TO BUY $MR Egypt TOKEN | Presale Live</title>
    <meta name="description"
        content="Don't miss the LAST CHANCE to buy $MR Egypt Token! Join the presale now and be part of Egypt's digital revolution. High staking rewards up to 25% APY." />
    <meta name="keywords" content="MR Egypt Token, cryptocurrency, presale, staking, Egypt, blockchain, tokenomics" />
    <meta property="og:title" content="MR Egypt Token - LAST CHANCE TO BUY $MR Egypt TOKEN" />
    <meta property="og:description"
        content="Don't miss the LAST CHANCE to buy $MR Egypt Token! Join the presale now and be part of Egypt's digital revolution." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="/mr-egypt-token-og.jpg" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="MR Egypt Token - LAST CHANCE TO BUY $MR Egypt TOKEN" />
    <meta name="twitter:description"
        content="Don't miss the LAST CHANCE to buy $MR Egypt Token! Join the presale now." />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for MR Egypt Token -->
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    @inertiaHead
</head>

<body class="font-sans antialiased bg-gray-900">
    @inertia
</body>

</html>