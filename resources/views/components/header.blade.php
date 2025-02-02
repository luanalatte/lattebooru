<header class="z-10 flex items-center justify-between gap-4 bg-white px-6 py-2 shadow-sm">
  <form class="w-full max-w-[400px]" action="{{ route('search') }}">
    <input class="w-full border px-3 py-1" type="search" placeholder="Search tags" name="q"
           value="{{ request()->query('q') }}">
  </form>
  <x-nav />
</header>
