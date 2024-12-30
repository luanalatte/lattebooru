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

  <script defer src="https://code.iconify.design/1/1.0.6/iconify.min.js"></script>
</head>

<body {{ $attributes->except(['title', 'nomenu'])->class(['flex min-h-[100vh] flex-col bg-gray-100']) }}>
  <header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2">
      <div class="flex items-center justify-between gap-3">
        <div class="flex gap-3">
          <a href="/">
            <h1 class="text-2xl font-semibold">{{ config('app.name') }}</h1>
          </a>
          <input class="rounded-md border px-2" type="search" placeholder="Search" form="search" name="q" value="{{ request()->query('q') }}">
          <form id="search" action="{{ route('search') }}"></form>
        </div>
        <nav class="flex gap-4">
          @auth
            <a class="text-blue-500 hover:text-blue-700" href="{{ route('logout') }}">Logout</a>
          @else
            <a class="text-blue-500 hover:text-blue-700" href="{{ route('login') }}">Login</a>
            <a class="text-blue-500 hover:text-blue-700" href="{{ route('register') }}">Register</a>
          @endauth
        </nav>
      </div>
    </div>
  </header>
  <div class="container mx-auto grid flex-grow grid-cols-[auto_1fr] gap-4 px-4 pb-8 pt-4">
    <aside
           class="{{ isset($aside) ? $aside->attributes->get('class') : '' }} min-h-100vh flex min-w-[200px] flex-col overflow-clip rounded-md">
      <div>
        @if (!isset($nomenu))
          <x-menu />
        @endif
        @isset($aside)
          {{ $aside }}
        @endisset
      </div>
      <a class="mt-auto flex w-full items-center gap-2 rounded-md px-4 py-2 text-gray-400" href="#">
        <i class="iconify" data-icon="mdi-arrow-up"></i>
        Back to the top
      </a>
    </aside>
    <main class="">
      {{ $slot }}
    </main>
  </div>
  <footer class="bg-white">
    <div class="container mx-auto px-4 py-4">
      <p class="text-center text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus vitae
        repellat mollitia.</p>
    </div>
  </footer>
</body>

</html>
