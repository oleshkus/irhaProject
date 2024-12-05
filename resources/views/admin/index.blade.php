@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">Панель управления</h2>
            <p class="mt-1 text-sm text-gray-500">Обзор статистики и управление системой</p>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <x-custom.stats-card 
                title="Пользователи"
                :value="$usersCount"
                :trend="$usersTrend"
                :trendValue="$usersTrendValue"
            >
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </x-slot>
            </x-custom.stats-card>

            <x-custom.stats-card 
                title="Маршруты"
                :value="$routesCount"
                :trend="$routesTrend"
                :trendValue="$routesTrendValue"
            >
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </x-slot>
            </x-custom.stats-card>

            <x-custom.stats-card 
                title="Достопримечательности"
                :value="$attractionsCount"
                :trend="$attractionsTrend"
                :trendValue="$attractionsTrendValue"
            >
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot>
            </x-custom.stats-card>

            <x-custom.stats-card 
                title="Изображения"
                :value="$imagesCount"
            >
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </x-slot>
            </x-custom.stats-card>
        </div>

        <!-- Графики -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <x-custom.chart 
                id="usersChart"
                title="Регистрации пользователей"
            />

            <x-custom.chart 
                id="contentChart"
                title="Создание контента"
            />
        </div>

        <!-- Быстрые действия -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Быстрые действия</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-3 text-gray-900">Управление пользователями</span>
                </a>

                <a href="{{ route('admin.routes.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span class="ml-3 text-gray-900">Создать маршрут</span>
                </a>

                <a href="{{ route('admin.attractions.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="ml-3 text-gray-900">Добавить достопримечательность</span>
                </a>
            </div>
        </div>

        <!-- Последние действия -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Последние действия</h3>
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @foreach($recentActivity as $activity)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $activity['icon'] !!}
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="{{ $activity['time'] }}">{{ $activity['time_formatted'] }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // График регистраций пользователей
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($userChartLabels) !!},
            datasets: [{
                label: 'Новые пользователи',
                data: {!! json_encode($userChartData) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // График создания контента
    const contentCtx = document.getElementById('contentChart').getContext('2d');
    new Chart(contentCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($contentChartLabels) !!},
            datasets: [{
                label: 'Маршруты',
                data: {!! json_encode($routesChartData) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
            }, {
                label: 'Достопримечательности',
                data: {!! json_encode($attractionsChartData) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
