@props(['class'])

<div
    @if(!empty($class))
        class="{{ $class }}"
    @endif
 >
    {{ $slot }}
</div>