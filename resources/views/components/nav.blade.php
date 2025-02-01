<nav class="space-y-3 pb-1">
  <x-nav-link title="Home" url="/" icon="mdi:home" />
  @can('create', App\Models\Post::class)
    <x-nav-link title="Upload" url="{{ route('upload') }}" icon="mdi:upload" />
  @endcan
  <x-nav-link title="Tags" url="{{ route('tags.index') }}" icon="mdi:tag" />
  <x-nav-link title="Users" url="{{ route('users.index') }}" icon="mdi:account" />
  @auth
    <x-nav-link title="Trash" url="{{ route('trash.index') }}" icon="mdi:trash" />
  @endauth
  @can('admin_panel')
    <x-nav-link title="Admin" url="{{ route('admin') }}" icon="mdi:cog" />
  @endcan
</nav>
