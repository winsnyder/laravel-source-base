<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UseCase\Product\ProductUseCase;
use App\UseCase\Product\ProductService;
use App\Infrastructure\Repositories\Product\IProductRepository;
use App\Infrastructure\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ProductUseCase::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $sqlWithPlaceholders = str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $query->sql);

                $bindings = $query->connection->prepareBindings($query->bindings);
                $pdo = $query->connection->getPdo();
                $realSql = $sqlWithPlaceholders;
                // $duration = $this->formatDuration($query->time / 1000);

                if (count($bindings) > 0) {
                    $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
                }

                error_log($realSql);
            });
        }
    }
}
