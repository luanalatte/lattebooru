<x-layouts.app>
  <x-slot name="aside">
    <div class="space-y-3">
      <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
        <h2 class="font-medium">Details</h2>
        <ul class="space-y-1 text-sm">
          <li>
            <span class="font-medium">Author:</span>
            <a class="text-blue-500" href="#"><span>{{ $post->author->username }}</span></a>
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
  <div class="rounded-md bg-white p-3 shadow-sm">
    <img class="mx-auto rounded-md" loading="lazy" src="{{ route('_image', [$post->md5]) }}"
         alt="{{ $post->filename }}" title="{{ $post->filename }}">
  </div>
</x-layouts.app>
