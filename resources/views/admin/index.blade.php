<x-layouts.app>
  <x-notice />
  <section class="rounded-md bg-white px-4 py-2 shadow-sm">
    <h2 class="mb-2 text-lg">Admin</h2>
    <form action="{{ route('users.store') }}" method="POST">
      <fieldset class="my-4 max-w-[400px] rounded-md border p-4">
        <legend>Create user</legend>
        @csrf
        <div class="space-y-2">
          <div class="grid columns-2">
            <label for="username">Username:</label>
            <input class="border py-1" id="username" type="text" name="username" value="{{ old('username') }}"
                   minlength="3" maxlength="20" required autofocus>
            @error('username')
              <span class="text-red-500">{{ $message }}</span>
            @enderror
          </div>
          <div class="grid columns-2">
            <label for="email">Email:</label>
            <input class="border py-1" id="email" type="email" name="email" value="{{ old('email') }}"
                   required>
            @error('email')
              <span class="text-red-500">{{ $message }}</span>
            @enderror
          </div>
          <div class="grid columns-2">
            <label for="password">Password:</label>
            <input class="border py-1" id="password" type="password" name="password" minlength=8 required>
            @error('password')
              <span class="text-red-500">{{ $message }}</span>
            @enderror
          </div>
          <div class="grid columns-2">
            <label for="password_confirmation">Repeat password:</label>
            <input class="border py-1" id="password_confirmation" type="password" name="password_confirmation" required>
            @error('password_confirmation')
              <span class="text-red-500">{{ $message }}</span>
            @enderror
          </div>
          <div>
            <button class="btn-blue w-full" type="submit">Create User</button>
          </div>
        </div>
      </fieldset>
    </form>
  </section>
</x-layouts.app>
