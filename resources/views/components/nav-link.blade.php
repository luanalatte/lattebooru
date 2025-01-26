@props(['title', 'url', 'icon'])

<a
   {{ $attributes->merge([
           'href' => $url,
           'title' => $title,
       ])->class(['flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm']) }}>
  <x-icon name="{{ $icon }}" />
  {{ $title }}
</a>
