@props(['post'])

<a href="{{ route('post.show', [$post]) }}">
  <article class="relative aspect-square overflow-hidden rounded-md bg-white shadow-sm">
    <img @class(['h-full w-full object-contain']) loading="lazy" src="{{ route('_thumb', [$post->md5]) }}">
    <div class="absolute bottom-0 z-20 w-full p-2 text-lg text-gray-300">
      @if ($post->is_private)
        <i class="iconify" title="{{ __('post.visibility.status', [strtolower(__('post.visibility.private'))]) }}." data-icon="mdi-lock"></i>
      @elseif ($post->is_hidden)
        <i class="iconify" title="{{ __('post.visibility.status', [strtolower(__('post.visibility.hidden'))]) }}." data-icon="mdi-eye-off"></i>
      @endif
    </div>
  </article>
</a>
