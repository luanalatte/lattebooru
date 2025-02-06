<x-layouts.app title="Home">
  <x-slot name="aside">
    <x-sidebar.tag-list title="Popular Tags" :tags="$popularTags" />
  </x-slot>
  <x-posts.grid :$posts />
</x-layouts.app>
