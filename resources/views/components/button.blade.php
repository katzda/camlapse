@props(['href', 'icon', 'title', 'class'])

<a
    {{ $attributes->merge([ 'class' => 'inline-block' ]) }}
    href="{{ $href }}"
>
    <x-icon id="{{$icon}}"/>
    {{$title}}
</a>