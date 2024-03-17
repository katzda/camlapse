@props(['h2'])

<a
    href=""
    id="docs-card"
    class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
>
    <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch">
        <x-image
            src="https://laravel.com/assets/img/welcome/docs-dark.svg"
            class="hidden drop-shadow-[0px_4px_34px_rgba(0,0,0,0.25)] dark:block"
        />
    </div>

    <div class="relative flex items-center gap-6 lg:items-end">

        <x-arrow-r />

    </div>
</a>