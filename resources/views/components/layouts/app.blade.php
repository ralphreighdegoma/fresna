<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Default Title' }}</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div class="container">
        {{ $slot }} <!-- This will render the content of your Livewire component -->
    </div>

    @livewireScripts
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
