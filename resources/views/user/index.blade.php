<x-layouts.app title="Users">
  <x-slot name="aside">
    <section class="space-y-3 rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
      <h2 class="font-medium">Users</h2>
      <ul>
        <li>
          @foreach ($users as $user)
            <a class="text-blue-500" href="{{ route('user.show', [$user]) }}">
              {{ $user->username }}
            </a>
          @endforeach
        </li>
      </ul>
    </section>
  </x-slot>
</x-layouts.app>
