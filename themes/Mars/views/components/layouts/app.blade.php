<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ config('app.dir') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css'], 'Mars')
    <link rel="icon" href="/fav.svg" />
    {{ $head ?? '' }}
</head>
<body {{ $attributes }}>

<div id="app" >
    {{ $slot }}
</div>

@vite(['resources/js/app.js'], 'Mars')
</body>
</html>