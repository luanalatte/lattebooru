@props(['post'])

<div class="text-sm" x-data="visibilityData">
  <script>
    let visibilityData = {
      visibility: {{ $post->visibility }},
      submit() {
        return axios.post("{{ route('post.setVisibility', [$post]) }}", {
            visibility: this.visibility
          })
          .then(response => {
            this.visibility = response.data.visibility;
          })
          .catch(error => {
            console.log(error.message);
          });
      }
    }
  </script>
  <label class="mb-1 block">Visibility</label>
  <select class="w-full rounded-md border bg-transparent px-4 py-2" x-on:change="submit" x-model="visibility">
    @foreach (App\Enums\PostVisibility::cases() as $item)
      <option value="{{ $item }}" {{ $item == $post->visibility ? 'selected' : '' }}>
        {{ $item->toString() }}</option>
    @endforeach
  </select>
</div>
