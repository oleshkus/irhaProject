<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Route;
use App\Models\Attraction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Получаем основную статистику
        $usersCount = User::count();
        $routesCount = Route::count();
        $attractionsCount = Attraction::count();
        $imagesCount = $this->countImages();

        // Тренды (за последние 7 дней по сравнению с предыдущими 7 днями)
        $usersTrend = $this->calculateTrend('users');
        $routesTrend = $this->calculateTrend('routes');
        $attractionsTrend = $this->calculateTrend('attractions');

        $usersTrendValue = $usersTrend['value'];
        $routesTrendValue = $routesTrend['value'];
        $attractionsTrendValue = $attractionsTrend['value'];

        // Данные для графиков
        $userChartData = $this->getUserRegistrationData();
        $userChartLabels = $userChartData['labels'];
        $userChartData = $userChartData['data'];
        $contentChartData = $this->getContentCreationData();
        $contentChartLabels = $contentChartData['labels'];
        $routesChartData = $contentChartData['routes'];
        $attractionsChartData = $contentChartData['attractions'];

        // Последние действия
        $recentActivity = $this->getRecentActivity();

        return view('admin.index', compact(
            'usersCount',
            'routesCount',
            'attractionsCount',
            'imagesCount',
            'usersTrend',
            'routesTrend',
            'attractionsTrend',
            'usersTrendValue',
            'routesTrendValue',
            'attractionsTrendValue',
            'userChartData',
            'userChartLabels',
            'contentChartLabels',
            'routesChartData',
            'attractionsChartData',
            'recentActivity'
        ));
    }

    private function countImages()
    {
        return count(Storage::disk('public')->allFiles('images'));
    }

    private function calculateTrend($table)
    {
        $now = Carbon::now();
        $lastWeek = DB::table($table)
            ->whereBetween('created_at', [$now->copy()->subDays(7), $now])
            ->count();
        
        $previousWeek = DB::table($table)
            ->whereBetween('created_at', [$now->copy()->subDays(14), $now->copy()->subDays(7)])
            ->count();

        if ($previousWeek == 0) {
            return [
                'direction' => $lastWeek > 0 ? 'up' : null,
                'value' => $lastWeek > 0 ? '+100%' : '0%'
            ];
        }

        $change = (($lastWeek - $previousWeek) / $previousWeek) * 100;
        
        return [
            'direction' => $change >= 0 ? 'up' : 'down',
            'value' => sprintf('%+.1f%%', $change)
        ];
    }

    private function getUserRegistrationData()
    {
        $days = 30;
        $data = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $counts = [];
        $current = Carbon::now()->subDays($days);
        $end = Carbon::now();

        while ($current <= $end) {
            $currentDate = $current->format('Y-m-d');
            $dayData = $data->firstWhere('date', $currentDate);
            
            $labels[] = $current->format('d.m');
            $counts[] = $dayData ? $dayData->count : 0;
            
            $current->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $counts
        ];
    }

    private function getContentCreationData()
    {
        $months = 6;
        $start = Carbon::now()->subMonths($months)->startOfMonth();
        
        $routes = DB::table('routes')
            ->select(DB::raw('strftime("%Y-%m", created_at) as month'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $start)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $attractions = DB::table('attractions')
            ->select(DB::raw('strftime("%Y-%m", created_at) as month'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $start)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $routeCounts = [];
        $attractionCounts = [];
        $current = $start;
        $end = Carbon::now()->endOfMonth();

        while ($current <= $end) {
            $currentMonth = $current->format('Y-m');
            $monthLabel = $current->format('M Y');
            
            $routeData = $routes->firstWhere('month', $currentMonth);
            $attractionData = $attractions->firstWhere('month', $currentMonth);
            
            $labels[] = $monthLabel;
            $routeCounts[] = $routeData ? $routeData->count : 0;
            $attractionCounts[] = $attractionData ? $attractionData->count : 0;
            
            $current->addMonth();
        }

        return [
            'labels' => $labels,
            'routes' => $routeCounts,
            'attractions' => $attractionCounts
        ];
    }

    private function getRecentActivity()
    {
        $activity = collect();

        // Последние пользователи
        $users = User::latest()->take(5)->get()->map(function ($user) {
            return [
                'type' => 'user',
                'description' => "Новый пользователь: {$user->name}",
                'time' => $user->created_at,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />'
            ];
        });

        // Последние маршруты
        $routes = Route::latest()->take(5)->get()->map(function ($route) {
            return [
                'type' => 'route',
                'description' => "Создан маршрут: {$route->name}",
                'time' => $route->created_at,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />'
            ];
        });

        // Последние достопримечательности
        $attractions = Attraction::latest()->take(5)->get()->map(function ($attraction) {
            return [
                'type' => 'attraction',
                'description' => "Добавлена достопримечательность: {$attraction->name}",
                'time' => $attraction->created_at,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />'
            ];
        });

        return $activity->concat($users)
            ->concat($routes)
            ->concat($attractions)
            ->sortByDesc('time')
            ->take(10)
            ->map(function ($item) {
                $item['time_formatted'] = Carbon::parse($item['time'])->diffForHumans();
                return $item;
            });
    }
}
