<article class="border-b pb-2">
  <p x-text="comment.text"></p>
  <p class="font-light">
    <a class="text-blue-400" href="" x-text="comment.author.username"></a>
    commented
    <span></span>
  </p>
  <div class="mt-1 flex gap-3">
    <a class="flex items-center gap-1 text-sm" href="#">
      <x-icon name="mdi:reply" /> Reply
    </a>
    <form action="{{ route('comments.destroy', '') }}" method="post"
          x-bind:action="`{{ route('comments.destroy', '') }}/${comment.id}`">
      @csrf
      @method('delete')
      <button class="flex items-center gap-1 text-sm text-red-500"
              x-show="comment.author.id === {{ request()->user()?->id }}">
        <x-icon name="mdi:delete" /> Delete
      </button>
    </form>
  </div>
</article>
