<x-custom.header></x-custom.header>
<x-default-layout>
    <div class="min-h-screen bg-gray-100">
        
        
        <!-- Hero Section -->
        <div class="relative bg-blue-700">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2946&q=80" alt="Hero background">
                <div class="absolute inset-0 bg-blue-700 mix-blend-multiply"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Откройте для себя новые места</h1>
                <p class="mt-6 text-xl text-white max-w-3xl">Исследуйте удивительные достопримечательности и создавайте незабываемые маршруты путешествий.</p>
                <div class="mt-10">
                    <a href="{{ route('attractions.index') }}" class="inline-block bg-white py-3 px-8 rounded-md font-medium text-blue-700 hover:bg-blue-50">Начать путешествие</a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-700 font-semibold tracking-wide uppercase">Возможности</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Всё необходимое для путешествий</p>
                </div>

                <div class="mt-10">
                    <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <!-- Feature 1 -->
                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-700 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Достопримечательности</h3>
                                <p class="mt-2 text-base text-gray-500">Исследуйте самые интересные места и узнавайте их историю.</p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-700 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Маршруты</h3>
                                <p class="mt-2 text-base text-gray-500">Создавайте собственные маршруты или выбирайте готовые.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Attractions Section -->
        <div class="bg-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center mb-10">
                    <h2 class="text-base text-blue-700 font-semibold tracking-wide uppercase">Популярные места</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Исследуйте лучшие достопримечательности</p>
                </div>
                
                <x-attraction></x-attraction>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-blue-700">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Готовы начать путешествие?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Присоединяйтесь к нам и откройте для себя новые горизонты.
                </p>
                <a href="{{ route('register') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 sm:w-auto">
                    Зарегистрироваться
                </a>
            </div>
        </div>
    </div>
</x-default-layout>
