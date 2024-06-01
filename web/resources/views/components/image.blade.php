@props(['src'])

<div>
    <img
        src="{{ $src }}"
        {{ $attributes->merge(['class' => 'aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]']) }}
        onerror="
            document.getElementById('screenshot-container').classList.add('!hidden');
            document.getElementById('docs-card').classList.add('!row-span-1');
            document.getElementById('docs-card-content').classList.add('!flex-row');
            document.getElementById('background').classList.add('!hidden');
        "
    />
</div>