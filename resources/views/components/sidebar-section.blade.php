@props(['title', 'cloak' => false])

<section {{ $attributes->class(['pb-2 pt-3']) }} @if ($cloak) x-cloak @endif>
  <h2 class="mb-2 font-medium">{{ $title }}</h2>
  {{ $slot }}
</section>
