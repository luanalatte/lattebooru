<article class="border-b pb-2">
  <p x-text="comment.text"></p>
  <p class="font-light">
    <a class="text-blue-400" href="" x-text="comment.author.username"></a>
    commented
    <span></span>
  </p>
  <div class="mt-1 flex gap-3">
    <a class="flex items-center gap-1 text-sm" href="#"><i class="iconify" data-icon="mdi-reply"></i> Reply</a>
    <a class="flex items-center gap-1 text-sm text-red-500" href="#"
       x-show="comment.author.id === {{ request()->user()?->id }}"><i class="iconify" data-icon="mdi-trash"></i>
      Delete</a>
  </div>
</article>
