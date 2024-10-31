<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ App::getLocale() === 'ru' ? 'Кино Приложение' : 'Movie App' }}</title>
    <link rel="stylesheet" href="/css/main.css">
    <livewire:styles>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-black text-white">
<nav class="border-b border-gray-800">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between px-4 py-6">
        <ul class="flex flex-col md:flex-row items-center">
            <li>
                <a href="{{ route('movies.index') }}">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix"
                         class="w-24">
                </a>
            </li>
            <li class="md:ml-16 mt-3 md:mt-0">
                <a href="{{ route('movies.index') }}"
                   class="hover:text-gray-300">{{ App::getLocale() === 'ru' ? 'Фильмы' : 'Movies' }}</a>
            </li>
            <li class="md:ml-6 mt-3 md:mt-0">
                <a href="{{ route('tv.index') }}"
                   class="hover:text-gray-300">{{ App::getLocale() === 'ru' ? 'Телешоу' : 'TV Shows' }}</a>
            </li>
            <li class="md:ml-6 mt-3 md:mt-0">
                <a href="{{ route('actors.index') }}"
                   class="hover:text-gray-300">{{ App::getLocale() === 'ru' ? 'Актеры' : 'Actors' }}</a>
            </li>
        </ul>
        <div class="flex flex-col md:flex-row items-center">
            <livewire:search-dropdown>
                <div class="md:ml-4 mt-3 md:mt-0">
                    <a href="#">
                        <img src="https://avatars.githubusercontent.com/u/81741344?v=4" alt="avatar"
                             class="rounded-full w-8 h-8">
                    </a>
                </div>
                <div class="md:ml-4 mt-3 md:mt-0">
                    <a href="{{ route('set-locale', 'en') }}"
                       class="hover:text-gray-300 {{ App::getLocale() === 'en' ? 'font-bold' : '' }}">EN</a> |
                    <a href="{{ route('set-locale', 'ru') }}"
                       class="hover:text-gray-300 {{ App::getLocale() === 'ru' ? 'font-bold' : '' }}">RU</a>
                </div>
        </div>
    </div>
    </div>
</nav>
@yield('content')
<footer>
    <div class="container mx-auto text-sm px-4 py-6">
        {{ App::getLocale() === 'ru' ? 'Сделано' : 'Powered by' }} <a href="https://github.com/iammaga"
                                                                      class="underline hover:text-gray-300">Magaツ</a>
    </div>
</footer>
<livewire:scripts>
@yield('scripts')
</body>
</html>
