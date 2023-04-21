<?php

namespace App\Providers;

use App\Models\MenuOption;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.aside.aside', function ($view) {
            $options = MenuOption::getMenu();
            $view->with('options', $options);
        });
    }
}