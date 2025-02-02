<x-layouts.app>
  <section>
    @if ($posts->isEmpty())
      <section class="card">
        <h2 class="text-lg">Trash is empty. Posts you delete will show up here.</h2>
      </section>
    @else
      <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6">
        @foreach ($posts as $post)
          <x-thumbnail :$post />
        @endforeach
      </div>

      {{ $posts->links() }}
    @endif
  </section>
</x-layouts.app>
