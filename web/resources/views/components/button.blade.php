@props(['href', 'icon', 'title'])

<a
    class="inline-block"
    href="{{ $href }}"
>
    <x-icon id="{{$icon}}"/>
    {{$title}}
</a>