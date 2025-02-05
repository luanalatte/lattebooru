<div x-data="{ tags: @js($tags) }" x-modelable="tags" {{ $attributes }} x-show="Object.keys(tags).length > 0" @xcloak(empty($tags))>
  <x-sidebar.section title="Tags">
    <ul x-remove>
      @foreach ($tags as $tag)
        <li class="text-nowrap">
          <a class="text-blue-500" href="{{ route('search', ['q' => $tag['name']]) }}">{{ $tag['name'] }}</a>
          <small class="text-gray-400">{{ $tag['count'] }}</small>
        </li>
      @endforeach
    </ul>
    <ul x-cloak x-show="tags">
      <template x-for="tag in tags" x-bind:key="tag.id">
        <li class="text-nowrap">
          <a class="text-blue-500" x-bind:href="`{{ route('search', '') }}/?q=${tag.name}`" x-text="tag.name"></a>
          <small class="text-gray-400" x-text="tag.count"></small>
        </li>
      </template>
    </ul>
  </x-sidebar.section>
</div>
