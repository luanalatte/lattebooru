@props(['post'])

<a title="{{ $post->tags->pluck('name')->implode(' ') }}" href="{{ route('posts.show', [$post]) }}">
  <article @class(['relative aspect-square overflow-hidden rounded-md bg-white shadow-sm', 'border-2 border-blue-400' => $post->isAnimated])>
    <img @class(['h-full w-full object-contain']) loading="lazy" src="{{ $post->thumbnailUrl }}">
    <div class="absolute bottom-0 z-20 w-full p-2 text-lg text-gray-300">
      @if ($post->is_private)
        <x-icon name="mdi:lock" title="{{ __("This post is :0", [strtolower(__("Private"))]) }}." />
      @elseif ($post->is_hidden)
        <x-icon name="mdi:eye-off" title="{{ __("This post is :0", [strtolower(__("Hidden"))]) }}." />
      @endif
    </div>
  </article>
</a>
