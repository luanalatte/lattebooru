<footer>
  <div class="container mx-auto px-4 py-2">
    <div class="flex justify-between text-gray-600">
      <p>
        @if (config('app.copyright'))
          {{ config('app.copyright') }}
        @endif
      </p>
      <div class="flex gap-4">
        <a class="flex items-center gap-2" href="https://github.com/luanalatte/lattebooru/issues" target="_blank"
           rel="external">
          <x-icon name="mdi:bug" /> Report an issue
        </a>
        <a class="flex items-center gap-2" href="https://github.com/luanalatte/lattebooru" target="_blank" rel="external">
          <x-icon name="mdi:github" /> Source
        </a>
      </div>
    </div>
  </div>
</footer>
