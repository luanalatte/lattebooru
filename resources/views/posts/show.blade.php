<x-layouts.app title="Post #{{ $post->id }}">
  @vite('resources/js/post.js')

  <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('post', @js($post->toResource()))
    });
  </script>

  <x-slot name="aside">
    <x-sidebar.tag-list :tags="$post->tags" x-model="$store.post.tags" />
    <x-posts.details :$post />
    @canany(['update', 'delete'], $post)
      <x-posts.actions :$post />
    @endcanany
  </x-slot>

  <section class="bg-neutral-50 p-3 shadow-sm">
    <img class="mx-auto" data-mode='fit' x-data="{ fit: true }" loading="lazy" x-on:click="fit = !fit"
         x-bind:data-mode="fit ? 'fit' : 'full'" src="{{ route('_image', [$post]) }}" alt="{{ $post->image->filename }}"
         title="{{ $post->filename }}">
    @can('post_edit_tags', $post)
      <section class="mt-4">
        <x-tags.tag-editor class="mx-auto max-w-[800px]" :$post x-model="$store.post.tags" />
      </section>
    @endcan
  </section>

  <section class="mt-4 bg-neutral-50 px-4 pb-3 pt-2 shadow-sm">
    <h2 class="mb-2 text-lg">Comments</h2>
    <div class="mb-4 space-y-2" x-data="{ comments: @js($post->comments) }">
      <template x-for="comment in comments" x-bind:key="comment.id">
        <x-comment.comment />
      </template>
      <x-comment.comment-box :$post />
    </div>
  </section>
</x-layouts.app>
