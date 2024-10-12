<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name') }}</title>

  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <header class="container px-4 py-2">
    <div class="flex gap-3">
      <a href="/">
        <h1>{{ config('app.name') }}</h1>
      </a>
      @auth
        <a class="text-blue-500" href="{{ route('logout') }}">Logout</a>
        <a class="text-blue-500" href="{{ route('upload') }}">Upload</a>
      @else
        <a class="text-blue-500" href="{{ route('login') }}">Login</a>
        <a class="text-blue-500" href="{{ route('register') }}">Register</a>
      @endauth
    </div>
  </header>
  <main class="container px-4">
    {{ $slot }}
  </main>
</body>
</html>
