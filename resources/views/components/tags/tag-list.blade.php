<ul {{ $attributes }}>
  <template x-for="tag in tags" x-bind:key="tag.id">
    <li>
      <div>
        <a class="text-blue-500" x-bind:href="`{{ route('tag.show', '') }}/${tag.name}`" x-text="tag.name"></a>
        <small class="text-gray-400" x-text="tag.count"></small>
      </div>
    </li>
  </template>
</ul>
