<x-layouts.app title="Post #{{ $post->id }}" nonav x-data="{{ Js::from($post->toResource()) }}">
  @vite('resources/js/post.js')

  <x-slot name="aside">
    <div class="flex flex-col gap-3">
      <x-sidebar-section title="Tags" x-show="Object.keys(tags).length > 0" x-cloak>
        <x-tags.tag-list />
      </x-sidebar-section>
      <x-sidebar-section title="Details">
        <x-post.post-details :$post />
      </x-sidebar-section>
      @canany(['update', 'delete'], $post)
        <x-sidebar-section title="Actions">
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
        </x-sidebar-section>
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
