<x-layouts.app>
  <x-notice />
  <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
    <section class="bg-neutral-50 pb-4 lg:col-span-3">
      <form action="{{ route('admin.settings.update') }}" method="post" x-data x-ajax>
        @csrf
        <x-table.table :headers="['Setting', 'Value', 'Unit']">
          @foreach (\App\Enums\Settings::cases() as $enum)
            <tr>
              <x-table.td>{{ $enum->title() }}</x-table.td>
              @switch($enum->inputType())
                @case('select')
                  <x-table.td>
                    <select class="w-full border bg-white p-2" name="settings[{{ $enum->value }}]" {{ $enum->attributes() }}>
                      @foreach ($enum->values() as $option)
                        <option value="{{ $option }}" @selected($option === ($config[$enum->value] ?? $enum->default()))>{{ $option }}</option>
                      @endforeach
                    </select>
                  </x-table.td>
                @break

                @default
                  <x-table.td>
                    <input class="w-full border px-4 py-1" {{ $enum->attributes() }} name="settings[{{ $enum->value }}]"
                           value="{{ $config[$enum->value] ?? $enum->default() }}">
                  </x-table.td>
              @endswitch
              <x-table.td class="td">{{ $enum->unit() }}</x-table.td>
            </tr>
          @endforeach
        </x-table.table>
        <div class="mt-2 flex justify-end px-4">
          <button class="btn-lime" type="submit">
            <x-icon name="mdi:check" /> Apply config
          </button>
        </div>
      </form>
    </section>
    <section>
      <form action="{{ route('users.store') }}" method="POST">
        <fieldset class="card w-full border p-4">
          <legend class="px-2 text-lg">Create user</legend>
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
              <input class="border py-1" id="password_confirmation" type="password" name="password_confirmation"
                     required>
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
  </div>
</x-layouts.app>
