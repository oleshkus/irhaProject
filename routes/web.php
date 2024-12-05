<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\Admin\AttractionController as AdminAttractionController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
use App\Http\Controllers\RouteLikeController;
use App\Http\Controllers\AttractionLikeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

// -------------------------
// Маршруты для достопримечательностей
// -------------------------
Route::prefix('attractions')->group(function () {
    Route::get('/', [AttractionController::class, 'index'])->name('attractions.index');
    Route::get('/{attraction}', [AttractionController::class, 'show'])->name('attractions.show');
});

// Админский функционал для управления достопримечательностями
Route::middleware(['auth', 'admin'])->prefix('admin/attractions')->group(function () {
    Route::get('/', [AdminAttractionController::class, 'index'])->name('admin.attractions.index');
    Route::get('/create', [AdminAttractionController::class, 'create'])->name('admin.attractions.create');
    Route::post('/', [AdminAttractionController::class, 'store'])->name('admin.attractions.store');
    Route::get('/{attraction}/edit', [AdminAttractionController::class, 'edit'])->name('admin.attractions.edit');
    Route::put('/{attraction}', [AdminAttractionController::class, 'update'])->name('admin.attractions.update');
    Route::delete('/{attraction}', [AdminAttractionController::class, 'destroy'])->name('admin.attractions.destroy');
});

// -------------------------
// Маршруты для маршрутов (routes)
// -------------------------
Route::prefix('routes')->group(function () {
    Route::get('/', [RouteController::class, 'index'])->name('routes.index');
    Route::get('/{route}', [RouteController::class, 'show'])->name('routes.show');
});

// Админский функционал для управления маршрутами
Route::middleware(['auth', 'admin'])->prefix('admin/routes')->group(function () {
    Route::get('/', [AdminRouteController::class, 'index'])->name('admin.routes.index');
    Route::get('/create', [AdminRouteController::class, 'create'])->name('admin.routes.create');
    Route::post('/', [AdminRouteController::class, 'store'])->name('admin.routes.store');
    Route::get('/{route}/edit', [AdminRouteController::class, 'edit'])->name('admin.routes.edit');
    Route::put('/{route}', [AdminRouteController::class, 'update'])->name('admin.routes.update');
    Route::delete('/{route}', [AdminRouteController::class, 'destroy'])->name('admin.routes.destroy');
});

// -------------------------
// Профиль пользователя
// -------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.updateInfo');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------
// Административная панель
// -------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Главная страница админки
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    
    // Управление пользователями
    Route::resource('users', UserController::class)->names('admin.users');
    
    // Управление достопримечательностями и маршрутами
    Route::resource('attractions', AdminAttractionController::class)->names('admin.attractions');
    Route::resource('routes', AdminRouteController::class)->names('admin.routes');
    
    // Удаление изображений
    Route::delete('routes/images/{image}', [AdminRouteController::class, 'deleteImage'])->name('admin.routes.images.delete');
    Route::delete('attractions/images/{image}', [AdminAttractionController::class, 'deleteImage'])->name('admin.attractions.images.delete');
});

// -------------------------
// Аутентификация
// -------------------------
require __DIR__.'/auth.php';
