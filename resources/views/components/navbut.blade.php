@props(['icon', 'route'])

<a href="{{ route($route) }}" class="grow px-5 py-2 text-center text-slate-800 hover:bg-gray-300">
    <span class="mb-1 inline-block h-full w-full border-b-4 border-gray-200
                {{ request()->routeIs($route) ? 'bg-gray-200 border-b-blue-700' : '' }}"
    >
        <span class="inline-block text-red-600 w-[20px] h-[20px] align-text-bottom">
            @svg($icon)
        </span>
        <span class="inline-block">
            {{ $slot }}
        </span>
    </span>
</a>