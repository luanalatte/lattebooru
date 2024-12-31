@props(['title', 'url', 'icon'])

<a
   {{ $attributes->merge([
           'href' => $url,
           'title' => $title,
       ])->class(['flex w-full items-center gap-2 rounded-md bg-white px-4 py-2 shadow-sm']) }}>
  <i class="iconify" data-icon="{{ $icon }}"></i>
  {{ $title }}
</a>
