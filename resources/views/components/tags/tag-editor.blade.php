<div {{ $attributes }} x-data="{
    edit: false,
    tag: '',
    tags: {{ Js::from($post->tags->mapWithKeys(fn($tag) => [$tag->name => 1])) }},
}">
  <form action="" method="post" x-ref="form">
    @csrf
    <template x-for="(visible, tag) in tags" x-bind:key="tag">
      <input type="hidden" x-bind:name="`tags[${tag}]`" x-bind:value="visible">
    </template>
  </form>
  <div class="flex flex-wrap justify-center gap-2">
    <template x-for="(visible, tag) in tags" x-bind:key="tag">
      <div class="flex h-8 items-center" x-show="visible">
        <a class="text-blue-500" x-bind:href="`{{ route('tag.show', '') }}/${tag}`" x-text="tag" x-show="!edit"></a>
        <button class="flex h-6 w-min items-center gap-1 rounded-sm bg-blue-400 pe-2 ps-1 shadow-sm hover:border-red-500 hover:bg-red-500 hover:text-white"
                x-on:click="if(edit) {tags[tag] = 0}" x-show="edit" type="button">
          <i class="iconify" data-icon="mdi-close" x-show="edit"></i>
          <span x-text="tag"></span>
        </button>
      </div>
    </template>
  </div>
  <div class="mt-4 h-8">
    <div class="flex h-full w-full gap-3" x-show="edit" style="display: none;">
      <form class="flex-grow" x-on:submit.prevent="if(tag.trim()) { tags[tag.trim()] = 1; tag = ''}">
        <div class="flex h-full items-center overflow-hidden rounded-md border p-0 shadow-sm">
          <input class="w-full px-2" name="tag" type="text" placeholder="Add a tag" x-model="tag"
                 x-ref="taginput">
          <button class="px-2" type="submit">
            <i class="iconify" data-icon="mdi-plus"></i>
          </button>
        </div>
      </form>
      <button class="flex items-center gap-1 rounded-md bg-red-400 px-2 py-1 shadow-sm hover:bg-red-500 hover:text-white"
              x-on:click="edit = false" type="button">
        <i class="iconify" data-icon="mdi-close"></i>
        <span>Cancel</span>
      </button>
      <button class="flex items-center gap-1 rounded-md bg-lime-400 px-2 py-1 shadow-sm hover:bg-lime-500 hover:text-white"
              type="button" x-on:click="$refs.form.submit();">
        <i class="iconify" data-icon="mdi-tick"></i>
        <span>Confirm</span>
      </button>
    </div>
    <button class="ms-auto flex items-center gap-1 rounded-md bg-blue-400 px-2 py-1 shadow-sm hover:bg-blue-500 hover:text-white"
            x-show="!edit" x-on:click="edit = true;  window.setTimeout(() => $refs.taginput.focus(), 0);"
            type="button">
      <i class="iconify" data-icon="mdi-pencil"></i>
      <span>Edit Tags</span>
    </button>
  </div>
</div>
