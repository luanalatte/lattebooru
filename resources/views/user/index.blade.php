<x-layouts.app title="Users">
  <x-slot name="aside">
    <x-menu />
  </x-slot>
  <section class="rounded-md bg-white px-3 pb-4 pt-2 shadow-sm">
    <h2 class="mb-2 text-lg">Users</h2>
    <table>
      <thead>
        <tr>
          <th class="px-2 font-normal">User</th>
          <th class="px-2 font-normal">Role</th>
          <th class="px-2 font-normal">Posts</th>
          <th class="px-2 font-normal">Member since</th>
          <th class="px-2 font-normal">Last seen</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td class="px-2"><a class="text-blue-500" href="{{ route('user.show', [$user]) }}">{{ $user->username }}</a></td>
            <td class="px-2 capitalize">{{ $user->roles->first()->name }}</td>
            <td class="px-2">{{ $user->posts_count }}</td>
            <td class="px-2">{{ $user->created_at->toFormattedDateString() }}</td>
            <td class="px-2">@fuzzyDate($user->last_login_at)</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
</x-layouts.app>
