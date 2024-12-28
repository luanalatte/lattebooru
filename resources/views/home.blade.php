<x-layouts.app title="Home">
  <x-slot name="aside">
    @if ($popularTags->isNotEmpty())
      <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
        <h2 class="font-medium">Popular Tags</h2>
        <ul>
          @foreach ($popularTags as $tag)
            <li>
              <a class="text-blue-500" href="{{ route('tag.show', [$tag->name]) }}">
                {{ $tag->name }}
              </a>
              <small class="text-gray-400">{{ $tag->posts_count }}</small>
            </li>
          @endforeach
        </ul>
      </section>
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
