<?php

// app/Providers/ViewServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Передаем переменную $user во все представления, где используется 'components.custom.header'
        View::composer('components.custom.header', function ($view) {
            $view->with('user', auth()->user());
        });
    }
}
