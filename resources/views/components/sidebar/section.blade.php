@props(['title'])

<section {{ $attributes->class(['py-2 px-6']) }}>
  @isset($title)
    <h2 class="mb-2 mt-1 font-medium">{{ $title }}</h2>
  @endisset
  {{ $slot }}
</section>
