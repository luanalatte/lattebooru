@props(['title', 'cloak' => false])

<section {{ $attributes->class(['space-y-2 px-4 py-3']) }} @if ($cloak) x-cloak @endif>
  <h2 class="font-medium">{{ $title }}</h2>
  {{ $slot }}
</section>
