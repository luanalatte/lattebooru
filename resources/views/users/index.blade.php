<x-layouts.app title="Users">
  <x-table.table class="bg-neutral-50 shadow-sm" :headers="['User', 'Role', 'Posts', 'Member since', 'Last seen']">
    @foreach ($users as $user)
      <tr>
        <x-table.td>
          <a class="text-blue-500" href="{{ route('users.show', [$user]) }}">{{ $user->username }}</a>
        </x-table.td>
        <x-table.td class="capitalize">{{ $user->roles->first()->name }}</x-table.td>
        <x-table.td>{{ $user->posts_count }}</x-table.td>
        <x-table.td>{{ $user->created_at->toFormattedDateString() }}</x-table.td>
        <x-table.td>@fuzzyDate($user->last_login_at)</x-table.td>
      </tr>
    @endforeach
  </x-table.table>

  <div class="mt-4 empty:hidden">
    {{ $users->links() }}
  </div>
</x-layouts.app>
