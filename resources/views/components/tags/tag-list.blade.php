@props(['tags'])

<div {{ $attributes }}>
  <ul x-remove>
    @foreach ($tags as $tag)
      <li>
        <a class="text-blue-500" href="{{ route('tags.show', $tag->name) }}">{{ $tag->name }}</a>
        <small class="text-gray-400">{{ $tag->posts_count }}</small>
      </li>
    @endforeach
  </ul>
  <ul x-cloak x-show="tags">
    <template x-for="tag in tags" x-bind:key="tag.id">
      <li>
        <a class="text-blue-500" x-bind:href="`{{ route('tags.show', '') }}/${tag.name}`" x-text="tag.name"></a>
        <small class="text-gray-400" x-text="tag.count"></small>
      </li>
    </template>
  </ul>
</div>
