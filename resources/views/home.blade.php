<x-layouts.app title="Home">
  <x-slot name="aside">
    @if ($popularTags->isNotEmpty())
      <x-sidebar-section title="Popular Tags">
        <x-tags.tag-list :tags="$popularTags" />
      </x-sidebar-section>
    @endif
  </x-slot>
  <section>
    <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6">
      @foreach ($posts as $post)
        <x-thumbnail :$post />
      @endforeach
    </div>

    {{ $posts->links() }}
  </section>
</x-layouts.app>
