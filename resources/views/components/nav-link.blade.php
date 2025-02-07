@props(['icon', 'text', 'href'])

<a class="link px-1 md:hidden" href={{ $href }}}}">
  <x-icon name="{{ $icon }}" /> {{ $text }}
</a>
<a class="border p-2 max-md:hidden" href={{ $href }}}}" title="{{ $text }}">
  <x-icon name="{{ $icon }}" />
</a>
