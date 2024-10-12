<x-layouts.app>
  <img loading="lazy" src="{{ route('_image', [$post->md5]) }}" alt="{{ $post->filename }}" title="{{ $post->filename }}">
  @if (auth()->user()?->id == $post->user_id)
    <div class="mt-3 mb-10">
      <form action="{{ route('post.delete', [$post]) }}" method="post">
        @csrf
        <button type="submit" class="bg-red-500 text-white font-medium px-2 py-1 rounded">Delete</button>
      </form>
    </div>
  @endif
</x-layouts.app>
