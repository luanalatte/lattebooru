<x-layouts.app title="Profile: {{ $user->username }}">
  <x-slot name="aside">
    <x-sidebar.section title="{{ $user->username }}">
      <ul class="space-y-1 text-sm">
        <li>
          <span class="font-medium">Joined:</span>
          <span>{{ $user->created_at->format('d/m/Y') }}</span>
        </li>
        <li>
          <span class="font-medium">Last seen:</span>
          <span class="inline-block first-letter:uppercase">@fuzzyDate($user->last_login_at)</span>
        </li>
        <li>
          <span class="font-medium">Posts:</span>
          <span>{{ $posts->total() }}</span>
        </li>
      </ul>
    </x-sidebar.section>
  </x-slot>

  <x-posts.grid :$posts />
</x-layouts.app>
