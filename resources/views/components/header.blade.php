<header class="z-10 grid h-12 grid-cols-[1fr_auto] items-center bg-white shadow-sm">
  <div class="container flex min-w-full items-center justify-between gap-4 pe-2 ps-6 lg:pe-6">
    <form class="w-full max-w-[400px]" action="{{ route('search') }}">
      <input class="w-full border px-3 py-1" type="search" placeholder="Search tags" name="q"
             value="{{ request()->query('q') }}">
    </form>
    <x-nav class="max-md:hidden" />
  </div>
  <button class="me-2 h-full px-3 lg:hidden" type="button" x-data
          x-on:click="$store.sidebar.collapsed = !$store.sidebar.collapsed">
    <x-icon name="mdi:hamburger-menu" />
  </button>
</header>
