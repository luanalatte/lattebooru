<div {{ $attributes->class(['overflow-x-auto']) }}>
  <table class="min-w-full">
    <thead class="bg-gray-800 text-white">
      <tr class="uppercase">
        @foreach ($headers as $header)
          <th class="px-6 py-3 text-start text-sm font-light" scope="col">{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody class="divide-y divide-neutral-200 font-light">
      {{ $slot }}
    </tbody>
  </table>
</div>
