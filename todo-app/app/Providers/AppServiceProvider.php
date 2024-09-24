<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TodoRepositoryInterface;
use App\Repositories\TodoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    
        

    public function register()
    {
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
