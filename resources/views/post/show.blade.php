<x-layouts.app title="Post #{{ $post->id }}" nomenu>
  <x-slot name="aside">
    <div class="space-y-3">
      @if ($post->tags->isNotEmpty())
        <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
          <h2 class="font-medium">Tags</h2>
          <ul>
            @foreach ($post->tags as $tag)
              <li>
                <a class="text-blue-500" href="{{ route('tag.show', [$tag->name]) }}">
                  {{ $tag->name }}
                </a>
                <small class="text-gray-400">{{ $tag->posts_count }}</small>
              </li>
            @endforeach
          </ul>
        </section>
      @endif
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
            <div class="text-sm">
              <form action="{{ route('post.setVisibility', [$post]) }}" method="post">
                @csrf
                <label class="mb-1 block">Visibility</label>
                <select class="w-full rounded-md border bg-transparent px-4 py-2" name="visibility"
                        onchange="this.form.submit()">
                  @foreach (App\Enums\PostVisibility::cases() as $item)
                    <option value="{{ $item }}" {{ $item == $post->visibility ? 'selected' : '' }}>
                      {{ $item->toString() }}</option>
                  @endforeach
                </select>
              </form>
            </div>
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
  <section class="rounded-md bg-white p-3 shadow-sm">
    <x-tags.tag-editor class="mx-auto max-w-[800px]" :$post />
  </section>
</x-layouts.app>
