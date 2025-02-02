@props(['posts'])

<div>
  <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6">
    @foreach ($posts as $post)
      <x-thumbnail :$post />
    @endforeach
  </div>
  <div class="mt-4 empty:hidden">
    {{ $posts->links() }}
  </div>
</div>
