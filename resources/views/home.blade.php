<x-layouts.app title="Home">
  <x-slot name="aside">
    <nav class="flex h-full flex-col gap-3">
      <a class="flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm" href="/">
        <i class="iconify" data-icon="mdi-home"></i>
        Home
      </a>
      @can('create', App\Models\Post::class)
        <a class="flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm" href="{{ route('upload') }}">
          <i class="iconify" data-icon="mdi-upload"></i>
          Upload
        </a>
      @endcan
      <a class="mt-auto flex w-full items-center gap-2 rounded-md px-4 py-2 text-gray-400" href="#">
        <i class="iconify" data-icon="mdi-arrow-up"></i>
        Back to the top
      </a>
    </nav>
  </x-slot>
  <section class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
    @foreach ($posts as $post)
      <a href="{{ route('post.show', [$post]) }}">
        <article class="overflow-clip rounded-md bg-white shadow-sm">
          <img class="aspect-square w-full object-contain" loading="lazy" src="{{ route('_thumb', [$post->md5]) }}">
        </article>
      </a>
    @endforeach
  </section>
</x-layouts.app>
