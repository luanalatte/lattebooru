<x-layouts.app title="Home">
  <x-slot name="aside">
    @if ($popularTags->isNotEmpty())
      <x-sidebar-section title="Popular Tags">
        <x-tags.tag-list :tags="$popularTags" />
      </x-sidebar-section>
    @endif
  </x-slot>
  <section>
    <x-posts.grid :$posts />
  </section>
</x-layouts.app>
