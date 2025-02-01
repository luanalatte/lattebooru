<div {{ $attributes->class(['rounded-md shadow-sm overflow-x-auto']) }}>
  <table class="min-w-full bg-gray-50">
    <thead class="bg-gray-800 text-white">
      <tr class="uppercase">
        @foreach ($headers as $header)
          <th class="px-6 py-3 text-start text-sm font-light" scope="col">{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 font-light">
      {{ $slot }}
    </tbody>
  </table>
</div>
