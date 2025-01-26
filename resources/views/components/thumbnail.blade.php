@props(['post'])

<a title="{{ $post->tags->pluck('name')->implode(' ') }}" href="{{ route('posts.show', [$post]) }}">
  <article class="relative aspect-square overflow-hidden rounded-md bg-white shadow-sm">
    <img @class(['h-full w-full object-contain']) loading="lazy" src="{{ route('_thumb', [$post->md5]) }}">
    <div class="absolute bottom-0 z-20 w-full p-2 text-lg text-gray-300">
      @if ($post->is_private)
        <x-icon name="mdi:lock" title="{{ __('post.visibility.status', [strtolower(__('post.visibility.private'))]) }}." />
      @elseif ($post->is_hidden)
        <x-icon name="mdi:eye-off" title="{{ __('post.visibility.status', [strtolower(__('post.visibility.hidden'))]) }}." />
      @endif
    </div>
  </article>
</a>
