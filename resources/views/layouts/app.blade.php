<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="loading">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')

        <!-- FOUC Prevention Script -->
        {{-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Даем небольшую задержку для загрузки стилей
                setTimeout(() => {
            document.documentElement.classList.remove('loading');
                }, 100);
            });
        </script> --}}
    </head>
    <body class="font-sans antialiased">
        <!-- Loading indicator -->
        {{-- <div class="page-loader">
            <svg class="animate-spin h-8 w-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div> --}}

        <div class="bg-gray-100">
            @if (session('status'))
                {{-- <x-notification>
                    {{ session('status') }}
                </x-notification> --}}
                <x-custom.notification :message="session('status')" type="success"></x-custom.notification>
            @endif
            
            <x-custom.header></x-custom.header>

            <main>
                @yield('content')
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
