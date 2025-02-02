<nav class="flex gap-4">
  <a class="link px-1" href="/">
    <x-icon name="mdi:image" /> Posts
  </a>
  @can('index', \App\Models\Tag::class)
    <a class="link px-1" href="{{ route('tags.index') }}">
      <x-icon name="mdi:tag" /> Tags
    </a>
  @endcan
  @can('index', \App\Models\User::class)
    <a class="link px-1" href="{{ route('users.index') }}">
      <x-icon name="mdi:account" /> Users
    </a>
  @endcan
  @can('admin_panel')
    <a class="border p-2" href="{{ route('admin') }}" title="Admin">
      <x-icon name="mdi:crown" />
    </a>
  @endcan
  @can('create', \App\Models\Post::class)
    <a class="border p-2" href="{{ route('upload') }}" title="Upload">
      <x-icon name="mdi:upload" />
    </a>
  @endcan
  @auth
    <a class="border p-2" href="{{ route('logout') }}" title="Logout"><x-icon name="mdi:logout" /></a>
  @else
    <a class="link" href="{{ route('login') }}">Login</a>
    @can('create', \App\Models\User::class)
      <a class="link" href="{{ route('register') }}">Register</a>
    @endcan
  @endauth
</nav>
