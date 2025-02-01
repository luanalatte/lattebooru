@props(['title', 'url', 'icon'])

<a
   {{ $attributes->merge([
           'href' => $url,
           'title' => $title,
       ])->class(['flex w-full items-center gap-2 font-light px-4 py-2']) }}>
  <x-icon name="{{ $icon }}" />
  {{ $title }}
</a>
