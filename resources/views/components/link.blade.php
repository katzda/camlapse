@props(['class', 'href'])

<a
    @if(!empty($class))
    class="{{ $class }}"
    @endif
    @if(!empty($href))
    href="{{ $href }}"
    @endif>
    {{ $slot }}
</a>