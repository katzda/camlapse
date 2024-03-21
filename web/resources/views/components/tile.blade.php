@props([])

<div
    class="w-fit px-[100px] pt-8 items-start gap-6 overflow-hidden rounded-lg bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 dark:bg-zinc-900 dark:ring-zinc-800 dark:focus-visible:ring-[#FF2D20]"
>
    {{-- <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch">
        <x-image
            src="https://laravel.com/assets/img/welcome/docs-dark.svg"
            class="hidden drop-shadow-[0px_4px_34px_rgba(0,0,0,0.25)] dark:block"
        />
    </div> --}}

    {{ $slot }}
</div>