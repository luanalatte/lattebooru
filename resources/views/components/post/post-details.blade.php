@props(['post'])

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
