<x-layouts.app title="Post #{{ $post->id }}" nonav x-data="{{ Js::from(new \App\Http\Resources\PostResource($post)) }}">
  <x-slot name="aside">
    <div class="flex flex-col gap-3">
      <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm" x-show="Object.keys(tags).length > 0" x-cloak>
        <h2 class="font-medium">Tags</h2>
        <x-tags.tag-list />
      </section>
      <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
        <h2 class="font-medium">Details</h2>
        <x-post.post-details :$post />
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
