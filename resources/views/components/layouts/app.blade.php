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
  <div class="container mx-auto flex">
    <aside class="z-20 w-1/4 max-w-[260px] border-r border-neutral-100 bg-white px-6 py-2">
      <div class="space-y-2 divide-y divide-neutral-100 empty:hidden">
        <a class="block" href="/">
          <h1 class="text-2xl font-medium">{{ config('app.name') }}</h1>
        </a>
        @isset($aside)
          {{ $aside }}
        @endisset
      </div>
    </aside>
    <div class="grid w-full grid-rows-[auto_1fr_auto]">
      <x-header />
      <main class="p-6">
        <div class="mb-4 border px-4 py-2 empty:hidden">{{ session('message') }}</div>
        {{ $slot }}
      </main>
      <x-footer />
    </div>
  </div>
  <x-toast />
</body>
</html>
