<x-layouts.app>
  <section>
    <x-notice />
    @if ($posts->isEmpty())
      <section class="rounded-md bg-white px-3 py-2 shadow-sm">
        <h2 class="mb-2 text-lg">Trash is empty. Posts you delete will show up here.</h2>
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
