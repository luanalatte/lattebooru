<!DOCTYPE html>
<html lang="en">
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
<body {{ $attributes->except('title')->class(['min-h-[100vh] bg-neutral-100 flex relative']) }}>
  <aside class="z-20 w-64 max-w-[100vw] overflow-x-clip border-r border-neutral-100 bg-white transition-all max-lg:absolute max-lg:h-full lg:min-h-full"
         x-data x-bind:class="$store.sidebar.collapsed && 'max-lg:w-0'">
    <div class="w-64 divide-y">
      <a class="flex h-12 items-center px-6" href="/">
        <h1 class="text-2xl font-medium">{{ config('app.name') }}</h1>
      </a>
      <x-nav class="flex-col items-start px-6 py-2 md:hidden" />
      @isset($aside)
        {{ $aside }}
      @endisset
    </div>
  </aside>
  <div class="grid w-full grid-rows-[auto_1fr_auto]">
    <x-header />

    <main class="p-6">
      <div class="container mx-auto">
        <div class="mb-4 border px-4 py-2 empty:hidden">{{ session('message') }}</div>
        {{ $slot }}
      </div>
    </main>

    <x-footer />
  </div>
  <x-toast />
</body>
</html>
