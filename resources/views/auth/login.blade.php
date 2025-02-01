<x-layouts.app title="Login">
  <section class="bg-gray-50 px-4 pt-2 pb-4 shadow-sm">
    <h2 class="mb-2 text-lg">Login</h2>
    <form action="" method="POST">
      @csrf
      <div class="max-w-[400px] space-y-2">
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
          <button class="w-full btn-blue" type="submit">Login</button>
        </div>
      </div>
    </form>
  </section>
</x-layouts.app>
