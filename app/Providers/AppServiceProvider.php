<?php

namespace App\Providers;

use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Infrastructure\Repositories\Setting\DatabaseSettingRepository;
use App\Infrastructure\Utils\FileSchemaRepository;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SchemaRepositoryInterface::class, FileSchemaRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, DatabaseSettingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function (QueryExecuted $query) {
            Log::debug('Query: ' . $query->sql);
            Log::debug('Time: ' . $query->time);
        });
    }
}
