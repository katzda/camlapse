<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="min-h-full h-full bg-black font-sans text-slate-100 antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CamLapse</title>

    <!-- Fonts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body class="min-h-full">
    <img class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" />
    <div class="relative flex flex-col items-center justify-start selection:bg-[#FF2D20] selection:text-white">
        <div class="w-full max-w-2xl px-6 lg:max-w-5xl">

            <header class="h-[50px] rounded-t-lg bg-gray-200 text-slate-900">
                <div class="flex h-full">
                    <x-navbut icon='zondicon-home' route="home">Devices</x-navbut>
                    <x-navbut icon='zondicon-list' route="camlapse.index">Time Lapses</x-navbut>
                    <x-navbut icon='zondicon-add-outline' route="camlapse.create">Create</x-navbut>
                </div>
            </header>

            <main class="mt-6">
                @yield('content')
            </main>

            <footer class="py-12 text-center text-sm text-slate-400">
                CamLapse
            </footer>
        </div>
    </div>
</body>

</html>