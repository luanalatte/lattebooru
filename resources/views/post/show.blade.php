<x-layouts.app>
  <img loading="lazy" src="{{ route('_image', [$post->md5]) }}" alt="{{ $post->filename }}" title="{{ $post->filename }}">
  @can('delete', $post)
    <div class="mb-10 mt-3">
      <form action="{{ route('post.delete', [$post]) }}" method="post">
        @csrf
        <button class="rounded bg-red-500 px-2 py-1 font-medium text-white" type="submit">Delete</button>
      </form>
    </div>
  @endcan
</x-layouts.app>
