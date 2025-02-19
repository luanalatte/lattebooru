@props(['post'])

<a title="{{ $post->tags->pluck('name')->implode(' ') }}" href="{{ route('posts.show', [$post]) }}">
  <article @class(['relative aspect-square overflow-hidden bg-neutral-50 shadow-sm', 'border-2 border-blue-400' => $post->isAnimated])>
    <img @class(['h-full w-full object-contain']) loading="lazy" src="{{ $post->thumbnailUrl }}">
    <div class="absolute bottom-0 z-20 w-full p-2 text-lg text-gray-300">
      @if ($post->is_private)
        <div title="{{ __("This post is :0.", [strtolower(__("Private"))]) }}">
          <x-icon name="mdi:lock" />
        </div>
      @elseif ($post->is_hidden)
        <div title="{{ __("This post is :0.", [strtolower(__("Private"))]) }}">
          <x-icon name="mdi:eye-off" />
        </div>
      @endif
    </div>
  </article>
</a>
