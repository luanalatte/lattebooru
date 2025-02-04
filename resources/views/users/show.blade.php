<x-layouts.app title="Profile: {{ $user->username }}" nonav>
  <x-slot name="aside">
    <x-sidebar-section title="{{ $user->username }}">
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
    </x-sidebar-section>
  </x-slot>
  <section>
    <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
      @foreach ($posts as $post)
        <x-thumbnail :$post />
      @endforeach
    </div>

    {{ $posts->links() }}
  </section>
</x-layouts.app>
