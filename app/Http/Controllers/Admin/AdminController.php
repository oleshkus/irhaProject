<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'attractions_count' => Attraction::count(),
            'routes_count' => Route::count(),
            'users_count' => User::count(),
        ];

        return view('admin.index', compact('stats'));
    }
}
