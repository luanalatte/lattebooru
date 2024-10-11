<x-layouts.app title="Login">
  <form action="" method="POST">
    @csrf
    <div class="mt-10 max-w-[400px] space-y-2">
      <div class="grid">
        <label for="username">Username:</label>
        <input class="border py-1" id="username" type="text" name="username" value="{{ old('username') }}" required
               autofocus>
        @error('username')
          <span class="text-red-500">{{ $message }}</span>
        @enderror
      </div>
      <div class="grid">
        <label for="password">Password:</label>
        <input class="border py-1" id="password" type="password" name="password" required>
      </div>
      <div class="my-2 grid py-1">
        <label for="remember" role="button">
          <input id="remember" type="checkbox" name="remember">
          Keep me logged in
        </label>
      </div>
      <div>
        <button class="w-full rounded bg-blue-500 px-3 py-1" type="submit">Login</button>
      </div>
    </div>
  </form>
</x-layouts.app>
