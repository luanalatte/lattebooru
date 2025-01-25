@props(['post'])
@vite('resources/js/tag-editor.js')

<div {{ $attributes }} x-data="tagEditor('{{ route('post.tags', [$post]) }}')">
  <div class="flex flex-wrap justify-center gap-2">
    <template x-for="(visible, tag) in tempTags" x-bind:key="tag">
      <div class="flex h-8 items-center" x-show="visible">
        <a class="text-blue-500" x-bind:href="`{{ route('tag.show', '') }}/${tag}`" x-text="tag" x-show="!edit"></a>
        <button class="flex h-6 w-min items-center gap-1 whitespace-nowrap rounded-sm bg-blue-400 pe-2 ps-1 shadow-sm hover:border-red-500 hover:bg-red-500 hover:text-white"
                x-on:click="removeTag(tag)" x-show="edit" type="button">
          <i class="iconify" data-icon="mdi-close" x-show="edit"></i>
          <span x-text="tag"></span>
        </button>
      </div>
    </template>
  </div>
  <div class="mt-4 h-8">
    <div class="flex h-full w-full gap-3" x-show="edit" x-cloak>
      <form class="flex-grow" x-on:submit.prevent="addTag($refs.taginput.value); $refs.taginput.value = '';">
        <div class="flex h-full items-center overflow-hidden rounded-md border p-0 shadow-sm">
          <input class="w-full px-2" type="text" placeholder="Add a tag" x-ref="taginput">
          <button class="px-2" type="submit">
            <i class="iconify" data-icon="mdi-plus"></i>
          </button>
        </div>
      </form>
      <button class="btn-red"
              x-on:click="cancelEditing()" type="button">
        <i class="iconify" data-icon="mdi-close"></i>
        <span>Cancel</span>
      </button>
      <button class="btn-lime"
              type="button" x-on:click="submitTags()">
        <i class="iconify" data-icon="mdi-tick"></i>
        <span>Confirm</span>
      </button>
    </div>
    <button class="ms-auto btn-blue"
            x-show="!edit" x-on:click="edit = true;  window.setTimeout(() => $refs.taginput.focus(), 0);"
            type="button">
      <i class="iconify" data-icon="mdi-pencil"></i>
      <span>Edit Tags</span>
    </button>
  </div>
</div>
