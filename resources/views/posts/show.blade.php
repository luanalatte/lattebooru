<x-layouts.app title="Post #{{ $post->id }}" nonav x-data="{{ Js::from($post->toResource()) }}">
  @vite('resources/js/post.js')

  <x-slot name="aside">
    <div class="flex flex-col gap-3">
      <x-sidebar-section title="Tags" x-show="Object.keys(tags).length > 0" :cloak="$post->tags->isEmpty()">
        <x-tags.tag-list :tags="$post->tags" />
      </x-sidebar-section>
      <x-sidebar-section title="Details">
        <x-post.post-details :$post />
      </x-sidebar-section>
      @canany(['update', 'delete'], $post)
        <x-sidebar-section title="Actions">
          @if ($post->trashed())
            <form action="{{ route('posts.restore', [$post]) }}" method="post">
              @csrf
              @method('patch')
              <button class="flex items-center gap-1 font-medium text-lime-500" type="submit">
                <x-icon name="mdi:restore" /> Restore
              </button>
            </form>
            <form action="{{ route('posts.forceDelete', [$post]) }}" method="post">
              @csrf
              @method('delete')
              <button class="flex items-center gap-1 font-medium text-red-500" type="submit">
                <x-icon name="mdi:delete" /> Permantently delete
              </button>
            </form>
          @else
            @can('update', $post)
              <x-post.visibility-select :$post />
            @endcan
            @can('delete', $post)
              <form action="{{ route('posts.destroy', [$post]) }}" method="post">
                @csrf
                @method('delete')
                <button class="flex items-center gap-1 font-medium text-red-500" type="submit">
                  <x-icon name="mdi:delete" /> Delete
                </button>
              </form>
            @endcan
          @endif
        </x-sidebar-section>
      @endcanany
    </div>
  </x-slot>
  <section class="rounded-md bg-white p-3 shadow-sm">
    <img class="mx-auto rounded-md" data-mode='fit' x-data="{ fit: true }" loading="lazy" x-on:click="fit = !fit"
         x-bind:data-mode="fit ? 'fit' : 'full'" src="{{ route('_image', [$post->md5]) }}" alt="{{ $post->filename }}"
         title="{{ $post->filename }}">
    @can('post_edit_tags', $post)
      <section class="mt-4">
        <x-tags.tag-editor class="mx-auto max-w-[800px]" :$post />
      </section>
    @endcan
  </section>
  <section class="mt-4 rounded-md bg-white px-4 pb-3 pt-2 shadow-sm">
    <h2 class="mb-2 text-lg">Comments</h2>
    <div class="mb-4 space-y-2" x-data="{ comments: @js($post->comments) }">
      <template x-for="comment in comments" x-bind:key="comment.id">
        <x-comment.comment />
      </template>
      <x-comment.comment-box :$post />
    </div>
  </section>
</x-layouts.app>
