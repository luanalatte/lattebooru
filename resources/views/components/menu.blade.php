<nav class="flex h-full flex-col gap-3">
  <a class="flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm" href="/">
    <i class="iconify" data-icon="mdi-home"></i>
    Home
  </a>
  @can('create', App\Models\Post::class)
    <a class="flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm" href="{{ route('upload') }}">
      <i class="iconify" data-icon="mdi-upload"></i>
      Upload
    </a>
  @endcan
  <a class="flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm" href="{{ route('users') }}">
    <i class="iconify" data-icon="mdi-user"></i>
    Users
  </a>
  <div class="mt-3">
    {{ $slot }}
  </div>
  <a class="mt-auto flex w-full items-center gap-2 rounded-md px-4 py-2 text-gray-400" href="#">
    <i class="iconify" data-icon="mdi-arrow-up"></i>
    Back to the top
  </a>
</nav>
