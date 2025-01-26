@if (session('message'))
  <div class="mb-4 rounded-md border bg-blue-200 px-4 py-1">
    <p>{{ session('message') }}</p>
  </div>
@endif
