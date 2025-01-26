<x-layouts.app>
  <section class="rounded-md bg-white px-4 pb-4 pt-2 shadow-sm">
    <x-notice />
    <h2 class="mb-2 text-lg">Email verification required</h2>
    <form action="{{ route('verification.send') }}" method="post">
      @csrf
      <button class="btn-blue">Send verification link</button>
    </form>
  </section>
</x-layouts.app>
