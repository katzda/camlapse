@props(['href', 'icon', 'title', 'class'])

<a
    {{ $attributes->merge([ 'class' => 'inline-block nav-icon hover:bg-[#ffe6e6]' ]) }}
    href="{{ $href }}"
>
    <x-icon id="{{$icon}}"/>
    {{$title}}
</a>