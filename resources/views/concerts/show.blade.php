<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    <h1>{{ $concert->title }}</h1>
    <h1>{{ $concert->subtitle }}</h1>
    <h1>{{ $concert->formatted_date }}</h1>
    <h1>{{ $concert->date->format('g:ia') }}</h1>
    <h1>{{ number_format($concert->ticket_price / 100, 2) }}</h1>
    <h1>{{ $concert->venue }}</h1>
    <h1>{{ $concert->venue_address }}</h1>
    <h1>{{ $concert->city }}, {{ $concert->state }} {{ $concert->zip }}</h1>
    <h1>{{ $concert->additional_information }}</h1>
    <h1>{{ $concert->created_at }}</h1>
    
    
</body>
</html>