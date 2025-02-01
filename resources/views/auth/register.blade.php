<x-layouts.app title="Register">
  <section class="card">
    <h2 class="mb-2 text-lg">Register</h2>
    <form action="" method="POST">
      @csrf
      <div class="mb-2 max-w-[400px] space-y-2">
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
          <input class="border py-1" id="email" type="email" name="email" value="{{ old('email') }}" required>
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
          <button class="btn-blue w-full" type="submit">Create Account</button>
        </div>
      </div>
    </form>
  </section>
</x-layouts.app>
