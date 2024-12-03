@props(['icon', 'route'])

<a href="{{ route($route) }}" class="grow text-center hover:bg-gray-400">
    <span class="inline-block border-gray-200 border-y-4 w-full h-full mb-1
                {{ request()->routeIs($route) ? 'bg-gray-200 border-b-blue-700' : 'hover:border-t-gray-400' }}"
    >
        <span class="inline-block text-red-600 w-[20px] h-[20px] align-text-bottom">
            @svg($icon)
        </span>
        <span class="inline-block">
            {{ $slot }}
        </span>
    </span>
</a>