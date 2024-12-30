<x-layouts.app title="Search">
  <section>
    <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6">
      @foreach ($posts as $post)
        <x-thumbnail :$post />
      @endforeach
    </div>

    {{ $posts->links() }}
  </section>
</x-layouts.app>
