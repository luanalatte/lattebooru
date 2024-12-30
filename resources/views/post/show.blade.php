<x-layouts.app title="Post #{{ $post->id }}" nomenu x-data="{ tags: {{ Js::from($tags) }}, visibility: {{ $post->visibility }}}">
  <x-slot name="aside">
    <div class="flex flex-col gap-3">
      <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm" x-show="Object.keys(tags).length > 0">
        <h2 class="font-medium">Tags</h2>
        <ul>
          <template x-for="(data, tag) in tags" x-bind:key="tag">
            <li>
              <a class="text-blue-500" x-bind:href="`{{ route('tag.show', '') }}/${tag}`" x-text="tag"></a>
              <small class="text-gray-400" x-text="data.count"></small>
            </li>
          </template>
        </ul>
      </section>
      <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
        <h2 class="font-medium">Details</h2>
        <ul class="space-y-1 text-sm">
          <li>
            <span class="font-medium">Author:</span>
            <a class="text-blue-500" href="{{ route('user.show', [$post->author]) }}">
              <span>{{ $post->author->username }}</span>
            </a>
          </li>
          <li>
            <span class="font-medium">Visibility:</span>
            <span>{{ $post->visibility->toString() }}</span>
          </li>
          <li>
            <span class="font-medium">Date:</span>
            <span>{{ $post->created_at->format('d/m/Y') }}</span>
          </li>
          <li>
            <span class="font-medium">Dimensions:</span>
            <span>{{ $post->width }}</span>
            x
            <span>{{ $post->height }}</span>
          </li>
          <li>
            <span class="font-medium">Size & Format:</span>
            <span>{{ Number::fileSize($post->filesize) }}</span>
            <span class="uppercase">{{ $post->ext }}</span>
          </li>
        </ul>
      </section>
      @canany(['update', 'delete'], $post)
        <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
          <h2 class="font-medium">Actions</h2>
          @can('update', $post)
            <x-post.visibility-select :$post />
          @endcan
          @can('delete', $post)
            <form action="{{ route('post.delete', [$post]) }}" method="post">
              @csrf
              <button class="text-center font-medium text-red-500" type="submit">
                <i class="iconify inline" data-icon="mdi-delete"></i> Delete
              </button>
            </form>
          @endcan
        </section>
      @endcanany
    </div>
  </x-slot>
  <section class="rounded-md bg-white p-3 shadow-sm">
    <img class="mx-auto rounded-md" data-mode='fit' x-data="{ fit: true }" loading="lazy" x-on:click="fit = !fit"
         x-bind:data-mode="fit ? 'fit' : 'full'" src="{{ route('_image', [$post->md5]) }}" alt="{{ $post->filename }}"
         title="{{ $post->filename }}">
  </section>
  @can('post_edit_tags', $post)
    <section class="rounded-md bg-white p-3 shadow-sm">
      <x-tags.tag-editor class="mx-auto max-w-[800px]" :$post />
    </section>
  @endcan
</x-layouts.app>
