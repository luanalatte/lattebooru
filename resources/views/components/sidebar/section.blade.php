@props(['title'])

<section {{ $attributes->class(['pb-2 pt-3 px-6']) }}>
  @isset($title)
    <h2 class="mb-2 font-medium">{{ $title }}</h2>
  @endisset
  {{ $slot }}
</section>
