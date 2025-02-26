@props(['post'])

<x-sidebar.section title="Details">
  <ul class="space-y-1 text-sm">
    <li>
      <span class="font-medium">Author:</span>
      <a class="text-blue-500" href="{{ route('users.show', [$post->author]) }}">
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
    <li>
      <a class="text-blue-500" href="{{ $post->image_url }}" target="_blank">View original</a>
    </li>
  </ul>
</x-sidebar.section>
