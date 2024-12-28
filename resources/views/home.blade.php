<x-layouts.app title="Home">
  <x-slot name="aside">
    <x-menu/>
  </x-slot>
  <section class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
    @foreach ($posts as $post)
      <x-thumbnail :$post />
    @endforeach
  </section>
</x-layouts.app>
