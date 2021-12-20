<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans bg-gray-background text-gray-900 text-sm">
        <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
            <a href="#">Vote ideas</a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
            
                                <a class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">
                                Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">
                                    Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <a href="#">
                    <img src="https://www.gravatar.com/avatar/000?d=mp" alt="Avatar del usuario"
                        class="w-10 h-10 rounded-full">
                </a>
            </div>
        </header><!-- fin-header -->

        <main class="container max-w-custom mx-auto flex flex-col md:flex-row">
            <div class="w-70 mx-auto md:mx-0 md:mr-5">
                <div class="bg-white md:sticky md:top-8 border-2 border-blue rounded-xl mt-16 form-border-gradient">
                    <div class="text-center px-6 py-2 pt-6">
                        <h3 class="font-semibold text-base">Add an idea</h3>
                        <p class="text-xs mt-4">
                        @auth
                            Let us know what you would like and we'll take a look over!
                        @else
                            Please login to create an idea.
                        @endauth
                        </p>
                    </div>

                    @auth
                        <livewire:create-idea />
                    @else
                        <div class="my-6 text-center">
                            <a href="{{ route('register') }}" class="inline-block w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                                Register
                            </a>
                            <a href="{{ route('login') }}" class="inline-block w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-4">
                                Login
                            </a>
                        </div>
                    @endauth
                </div>
            </div><!-- primera-columna -->
            <div class="w-full px-2 md:px-0 md:w-175">
                <nav class=" hidden md:flex items-center justify-between text-sm">
                    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                        <li>
                            <a href="#" class="border-b-4 pb-3 border-blue">All ideas(87)</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 transition duration-100 ease-in border-b-4 pb-3 hover:border-blue">
                                Considering (6)</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 transition duration-100 ease-in border-b-4 pb-3 hover:border-blue">
                                In progress (1)</a>
                        </li>
                    </ul>
                    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                        <li>
                            <a href="#" class="text-gray-400 transition duration-100 ease-in border-b-4 pb-3 hover:border-blue">
                                Implemented (10)</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 transition duration-100 ease-in border-b-4 pb-3 hover:border-blue">
                                Closed (55)</a>
                        </li>
                    </ul>
                </nav>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div><!-- segunda-columna -->
        </main>

        @livewireScripts
    </body>
</html>
