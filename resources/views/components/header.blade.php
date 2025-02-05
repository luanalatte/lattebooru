<header class="z-10 bg-white px-6 py-2 shadow-sm">
  <div class="container mx-auto flex items-center justify-between gap-4">
    <div class="flex gap-3">
      <button class="px-3 lg:hidden" type="button" x-data
              x-on:click="$store.sidebar.collapsed = !$store.sidebar.collapsed">
        <x-icon name="mdi:hamburger-menu" />
      </button>
      <form class="w-full max-w-[400px]" action="{{ route('search') }}">
        <input class="w-full border px-3 py-1" type="search" placeholder="Search tags" name="q"
               value="{{ request()->query('q') }}">
      </form>
    </div>
    <x-nav />
  </div>
</header>
