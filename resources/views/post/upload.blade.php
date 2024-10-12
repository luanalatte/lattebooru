<x-layouts.app title="Upload">
  <h2 class="mb-2 mt-10 text-xl">Upload</h2>
  <form action="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="max-w-[400px] space-y-2">
      <div class="grid">
        <input id="file" type="file" name="file" required>
        @error('file')
          <span class="text-red-500">{{ $message }}</span>
        @enderror
      </div>
      @error('upload')
        <div>
          <span class="text-red-500">{{ $message }}</span>
        </div>
      @enderror
      <div>
        <button class="w-full rounded bg-blue-500 px-3 py-1" type="submit">Upload</button>
      </div>
    </div>
  </form>
</x-layouts.app>
