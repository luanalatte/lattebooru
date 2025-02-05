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
<body {{ $attributes->except('title')->class(['flex min-h-[100vh] bg-neutral-100']) }}>
  <aside class="fixed z-20 min-h-full min-w-min overflow-clip border-r border-neutral-100 bg-white transition-transform md:w-1/4 md:max-w-[260px] lg:static lg:min-w-0"
         x-data x-bind:class="$store.sidebar.collapsed ? 'max-lg:-translate-x-full' : ''">
    <div class="divide-y divide-neutral-100">
      <div class="flex justify-between gap-3 ps-6">
        <a class="block py-2" href="/">
          <h1 class="text-2xl font-medium">{{ config('app.name') }}</h1>
        </a>
        <button class="px-3 lg:hidden" type="button" x-on:click="$store.sidebar.collapsed = !$store.sidebar.collapsed">
          <x-icon name="mdi:hamburger-menu" />
        </button>
      </div>
      @isset($aside)
        {{ $aside }}
      @endisset
    </div>
  </aside>
  <div class="grid w-full grid-rows-[auto_1fr_auto]">
    <x-header />
    <main class="p-6">
      <div class="container mx-auto h-full">
        <div class="mb-4 border px-4 py-2 empty:hidden">{{ session('message') }}</div>
        {{ $slot }}
      </div>
    </main>
    <x-footer />
  </div>
  <x-toast />
</body>
</html>
