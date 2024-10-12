<x-layouts.app title="Home">
  <section class="flex flex-wrap gap-3">
    @foreach ($posts as $post)
      <a class="rounded-md border" href="{{ route('post.show', [$post]) }}">
        <article>
          <img class="object-contain" loading="lazy" src="{{ route('_thumb', [$post->md5]) }}"
               style="height: 180px; width: 180px;">
        </article>
      </a>
    @endforeach
  </section>
</x-layouts.app>
