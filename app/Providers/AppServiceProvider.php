<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ProductServiceInterface;
use App\Contracts\OrderServiceInterface;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Services\WheelService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Product Service
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        
        // Bind Order Service
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        
        // Bind Wheel Service
        $this->app->singleton(WheelService::class, function ($app) {
            return new WheelService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Locale is now handled by SetLocale middleware
    }
}