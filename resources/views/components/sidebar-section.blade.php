@props(['title'])

<section {{ $attributes->class(['space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm']) }}>
  <h2 class="font-medium">{{ $title }}</h2>
  {{ $slot }}
</section>
