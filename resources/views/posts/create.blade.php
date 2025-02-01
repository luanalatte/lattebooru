<x-layouts.app title="Upload">
  <section class="bg-gray-50 px-4 py-2 shadow-sm">
    <h2 class="mb-2 text-lg">Upload</h2>
    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="max-w-[400px] space-y-2 mb-2">
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
  </section>
</x-layouts.app>
