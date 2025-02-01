<x-layouts.app title="Users">
  <x-table.table :headers="['User', 'Role', 'Posts', 'Member since', 'Last seen']">
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

  @if ($users->links())
    <div class="mt-4">
      {{ $users->links() }}
    </div>
  @endif
</x-layouts.app>
