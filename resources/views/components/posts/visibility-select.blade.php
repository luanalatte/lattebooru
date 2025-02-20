@props(['post'])

<div class="text-sm" x-data="visibilitySelect('{{ route('posts.setVisibility', [$post]) }}')">
  <label class="mb-1 block">Visibility</label>
  <select class="w-full rounded-md border bg-transparent px-4 py-2" x-on:change="submit" x-model="visibility.id">
    @foreach (App\Enums\Visibility::cases() as $item)
      <option value="{{ $item }}" @selected($item == $post->visibility)>
        {{ $item->toString() }}</option>
    @endforeach
  </select>
</div>
