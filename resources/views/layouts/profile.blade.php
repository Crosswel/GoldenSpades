<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'GoldSpades - Perfil')</title>
  <link rel="stylesheet" href="{{ asset('css/site.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color:white;">

  <main style="padding:20px;">
    @yield('content')
  </main>

</body>
</html>

