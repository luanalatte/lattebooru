@props(['post'])
@vite('resources/js/comment-box.js')

<div x-data="commentBox('{{ route('posts.addComment', $post) }}')">
  <form x-on:submit.prevent="submit()">
    <textarea class="w-full resize-none bg-transparent rounded-md border p-2" placeholder="Add a comment" rows="4" x-model="text"></textarea>
    <button class="ms-auto mt-2 btn-blue"
            type="submit">
      <x-icon name="mdi:comment"/>
      Comment
    </button>
  </form>
</div>
