<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name') }}</title>

  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

  <link rel="shortcut icon" href="https://api.iconify.design/mdi/image.svg" type="image/svg">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body {{ $attributes->except(['title', 'nonav'])->class(['grid min-h-[100vh] grid-rows-[1fr_auto] bg-neutral-100']) }}>
  <x-toast />
  <div class="container mx-auto grid grid-cols-[auto_1fr]">
    <aside
           class="{{ isset($aside) ? $aside->attributes->get('class') : '' }} flex min-w-[200px] flex-col overflow-clip bg-neutral-50 pt-2">
      <a class="mb-3 block w-[200px] px-4" href="/">
        <h1 class="text-2xl font-medium">{{ config('app.name') }}</h1>
      </a>
      <div class="divide-y divide-neutral-100">
        @if (!isset($nonav))
          <x-nav />
        @endif
        @isset($aside)
          {{ $aside }}
        @endisset
      </div>
      <a class="mt-auto flex w-full items-center gap-2 rounded-md px-4 py-2 text-gray-400" href="#">
        <x-icon name="mdi:arrow-up" />
        Back to the top
      </a>
    </aside>
    <div class="grid grid-rows-[auto_1fr_auto]">
      <header class="bg-neutral-50">
        <div class="container mx-auto px-4 py-2">
          <div class="flex items-center justify-between gap-3">
            <input class="rounded-md border px-2 py-1" type="search" placeholder="Search" form="search" name="q"
                   value="{{ request()->query('q') }}">
            <form id="search" action="{{ route('search') }}"></form>
            <nav class="flex gap-4">
              @auth
                <a class="text-blue-500 hover:text-blue-700" href="{{ route('logout') }}">Logout</a>
              @else
                <a class="text-blue-500 hover:text-blue-700" href="{{ route('login') }}">Login</a>
                @can('create', \App\Models\User::class)
                  <a class="text-blue-500 hover:text-blue-700" href="{{ route('register') }}">Register</a>
                @endcan
              @endauth
            </nav>
          </div>
        </div>
      </header>
      <main class="px-4 pb-8 pt-4">
        {{ $slot }}
      </main>
      <x-footer class="px-4 py-2" />
    </div>
  </div>
</body>

</html>
