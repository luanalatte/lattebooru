<nav {{ $attributes->class(['flex gap-4']) }}>
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
    <x-nav-link href="{{ route('admin') }}" text="Admin" icon="mdi:crown" />
  @endcan
  @can('create', \App\Models\Post::class)
    <x-nav-link href="{{ route('upload') }}" text="Upload" icon="mdi:upload" />
  @endcan
  @auth
    <x-nav-link href="{{ route('logout') }}" text="Logout" icon="mdi:logout" />
  @else
    <a class="link" href="{{ route('login') }}">Login</a>
    @can('create', \App\Models\User::class)
      <a class="link" href="{{ route('register') }}">Register</a>
    @endcan
  @endauth
</nav>
