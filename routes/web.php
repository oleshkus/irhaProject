<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\Admin\AttractionController as AdminAttractionController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
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
// Маршруты для категорий
// -------------------------
Route::middleware(['auth', 'admin'])->prefix('admin/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
     Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

// -------------------------
// Профиль пользователя
// -------------------------
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------
// Административная панель
// -------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin', function () {
        return view('admin.index');
    })->middleware(['auth', 'admin'])->name('admin');
});

// -------------------------
// Аутентификация
// -------------------------
require __DIR__.'/auth.php';
