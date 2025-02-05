@props(['post'])

<x-sidebar-section title="Actions">
  <div class="flex flex-col gap-2">
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
        <button class="flex items-center gap-1 text-nowrap font-medium text-red-500" type="submit">
          <x-icon name="mdi:delete" /> Permantently delete
        </button>
      </form>
    @else
      @can('update', $post)
        <form x-data="{ visibility: 0 }" x-modelable="visibility" x-model="$store.post.visibility.id"
              action="{{ route('posts.setVisibility', [$post]) }}" method="post" x-ajax x-on:change="$dispatch('submit')">
          @csrf
          <label class="mb-1 block">Visibility</label>
          <select class="w-full border bg-transparent px-4 py-2" name="visibility" x-model="visibility">
            @foreach (App\Enums\PostVisibility::cases() as $item)
              <option value="{{ $item }}">{{ $item->toString() }}</option>
            @endforeach
          </select>
        </form>
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
    @can('regenerateThumbnail', $post)
      <form action="{{ route('posts.regenerateThumbnail', [$post]) }}" method="post" x-ajax>
        @csrf
        <button class="flex items-center gap-1 text-nowrap font-medium text-blue-500" type="submit">
          <x-icon name="mdi:reload" /> Regenerate thumbnail
        </button>
      </form>
    @endcan
  </div>
</x-sidebar-section>
