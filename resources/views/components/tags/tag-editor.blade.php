@props(['post'])
@vite('resources/js/tag-editor.js')

<div {{ $attributes }} x-data="tagEditor('{{ route('posts.tags', [$post]) }}')" x-modelable="tags">
  <div class="flex flex-wrap justify-center gap-2" x-show="!edit">
    <template x-for="tag in tags" x-bind:key="tag.id">
      <div class="flex h-8 items-center">
        <a class="text-blue-500" x-bind:href="`{{ route('tags.show', '') }}/${tag.name}`" x-text="tag.name"></a>
      </div>
    </template>
  </div>
  <div class="flex flex-wrap justify-center gap-2" x-cloak x-show="edit">
    <template x-for="(visible, tag) in tempTags" x-bind:key="tag">
      <button class="flex h-6 w-min items-center gap-1 whitespace-nowrap rounded-sm bg-blue-400 pe-2 ps-1 shadow-sm hover:border-red-500 hover:bg-red-500 hover:text-white"
              x-on:click="removeTag(tag)" type="button" x-show="visible">
        <x-icon name="mdi:close" x-show="edit" />
        <span x-text="tag"></span>
      </button>
    </template>
  </div>
  <div class="mt-4 h-8">
    <div class="flex h-full w-full gap-3" x-show="edit" x-cloak>
      <form class="flex-grow" x-on:submit.prevent="addTag($refs.taginput.value); $refs.taginput.value = '';">
        <div class="flex h-full items-center overflow-hidden rounded-md border p-0 shadow-sm">
          <input class="w-full px-2" type="text" placeholder="Add a tag" x-ref="taginput">
          <button class="px-2" type="submit">
            <x-icon name="mdi:plus" />
          </button>
        </div>
      </form>
      <button class="btn-red" x-on:click="cancelEditing()" type="button">
        <x-icon name="mdi:close" />
        <span>Cancel</span>
      </button>
      <button class="btn-lime" type="button" x-on:click="submitTags()">
        <x-icon name="mdi:check" />
        <span>Confirm</span>
      </button>
    </div>
    <button class="btn-blue ms-auto" x-show="!edit" x-on:click="startEditing()" type="button">
      <x-icon name="mdi:pencil" />
      <span>Edit Tags</span>
    </button>
  </div>
</div>
