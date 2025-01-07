@props(['post'])
@vite('resources/js/comment-box.js')

<div x-data="commentBox('{{ route('post.addComment', $post) }}')">
  <form x-on:submit.prevent="submit()">
    <textarea class="w-full resize-none rounded-md border p-2" placeholder="Add a comment" rows="4" x-model="text"></textarea>
    <button class="ms-auto mt-2 flex items-center gap-2 rounded-md bg-blue-400 px-2 py-1 hover:bg-blue-500 hover:text-white"
            type="submit">
      <i class="iconify" data-icon="mdi-comment"></i>
      Comment
    </button>
  </form>
</div>
