<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

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
            <a href="/">Vote ideas</a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <div class="flex items-center space-x-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                                
                                <livewire:comment-notifications />
                            </div>
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
                @auth
                    <a href="#">
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar del usuario"
                            class="w-10 h-10 rounded-full">
                    </a>
                @endauth
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

                    <livewire:create-idea />
                </div>
            </div><!-- primera-columna -->
            <div class="w-full px-2 md:px-0 md:w-175">
                <livewire:status-filters />
                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div><!-- segunda-columna -->
        </main>

        @if (session('success_message')) 
            <x-popup-alert 
                type="success"
                :message="session('success_message')" 
                :showOnPageLoad="true"
            />
        @endif

        @if (session('error_message')) 
            <x-popup-alert 
                type="error"
                :message="session('error_message')" 
                :showOnPageLoad="true"
            />
        @endif

        @livewireScripts
    </body>
</html>
