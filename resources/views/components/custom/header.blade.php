<header x-data="{ 
    mobileMenuOpen: false,
    userMenuOpen: false,
    managementDropdown: false,
    profileDropdown: false 
}" class="bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg">
    <nav class="bg-gradient-to-r from-blue-800 to-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-white text-xl font-bold">
                        <span class="text-yellow-400">Travel</span>Guide
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="flex w-full justify-between items-center">
                    <!-- Left Side Navigation -->
                    <div class="hidden ml-10 sm:flex sm:space-x-4">
                        <x-custom.navigation.nav-link href="/" :active="request()->is('/')">
                            Главная
                        </x-custom.navigation.nav-link>

                        <x-custom.navigation.nav-link href="/routes" :active="request()->is('routes')">
                            Маршруты
                        </x-custom.navigation.nav-link>

                        <x-custom.navigation.nav-link href="/attractions" :active="request()->is('attractions')">
                            Достопримечательности
                        </x-custom.navigation.nav-link>

                        @auth
                            @if(auth()->user()->isAdmin())
                                <x-custom.navigation.nav-link href="/admin" :active="request()->is('admin*')">
                                    Админ панель
                                </x-custom.navigation.nav-link>
                            @endif
                        @endauth
                    </div>

                    <!-- Right Side Navigation -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <div class="relative" x-data="{ managementDropdown: false }">
                                    <button 
                                        @click.prevent="managementDropdown = !managementDropdown" 
                                        @click.away="managementDropdown = false"
                                        @keydown.escape.window="managementDropdown = false"
                                        class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out inline-flex items-center"
                                        :class="{ 'bg-blue-700': managementDropdown }">
                                        <span>Управление</span>
                                        <svg class="ml-2 h-5 w-5" :class="{ 'transform rotate-180': managementDropdown }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div x-show="managementDropdown"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute z-50 mt-2 right-0 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                                         style="display: none;">
                                        <a href="{{ route('admin.attractions.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.attractions.*') ? 'bg-gray-100' : '' }}">
                                            Достопримечательности
                                        </a>
                                        <a href="{{ route('admin.routes.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.routes.*') ? 'bg-gray-100' : '' }}">
                                            Маршруты
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="relative z-10">
                                <button 
                                    @click="profileDropdown = !profileDropdown" 
                                    @click.away="profileDropdown = false"
                                    class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out inline-flex items-center"
                                    :class="{ 'bg-blue-700': profileDropdown }">
                                    <span>{{ auth()->user()->name }}</span>
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div 
                                    x-show="profileDropdown"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                                    role="menu"
                                    aria-orientation="vertical"
                                    aria-labelledby="user-menu">
                                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Профиль</a>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            Выйти
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <x-custom.navigation.nav-link href="{{ route('login') }}">
                                Войти
                            </x-custom.navigation.nav-link>
                            <x-custom.navigation.nav-link href="{{ route('register') }}" class="bg-blue-500">
                                Регистрация
                            </x-custom.navigation.nav-link>
                        @endauth
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 focus:text-white transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <x-custom.navigation.nav-link href="/" :active="request()->is('/')" class="block">
                    Главная
                </x-custom.navigation.nav-link>

                <x-custom.navigation.nav-link href="/routes" :active="request()->is('routes')" class="block">
                    Маршруты
                </x-custom.navigation.nav-link>

                <x-custom.navigation.nav-link href="/attractions" :active="request()->is('attractions')" class="block">
                    Достопримечательности
                </x-custom.navigation.nav-link>

                @auth
                    @if(auth()->user()->isAdmin())
                        <x-custom.navigation.nav-link href="/admin" :active="request()->is('admin*')" class="block">
                            Админ панель
                        </x-custom.navigation.nav-link>
                    @endif

                    <div class="relative" x-data="{ managementDropdown: false }">
                        <button 
                            @click.prevent="managementDropdown = !managementDropdown" 
                            @click.away="managementDropdown = false"
                            @keydown.escape.window="managementDropdown = false"
                            class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out inline-flex items-center"
                            :class="{ 'bg-blue-700': managementDropdown }">
                            <span>Управление</span>
                            <svg class="ml-2 h-5 w-5" :class="{ 'transform rotate-180': managementDropdown }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="managementDropdown"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-50 mt-2 right-0 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                             style="display: none;">
                            <a href="{{ route('admin.attractions.index') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.attractions.*') ? 'bg-gray-100' : '' }}">
                                Достопримечательности
                            </a>
                            <a href="{{ route('admin.routes.index') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.routes.*') ? 'bg-gray-100' : '' }}">
                                Маршруты
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <button 
                            @click="profileDropdown = !profileDropdown" 
                            @click.away="profileDropdown = false"
                            class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out inline-flex items-center"
                            :class="{ 'bg-blue-700': profileDropdown }">
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div 
                            x-show="profileDropdown"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Профиль</a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <x-custom.navigation.nav-link href="{{ route('login') }}" class="block">
                        Войти
                    </x-custom.navigation.nav-link>
                    <x-custom.navigation.nav-link href="{{ route('register') }}" class="block bg-blue-500">
                        Регистрация
                    </x-custom.navigation.nav-link>
                @endauth
            </div>
        </div>
    </nav>
</header>
