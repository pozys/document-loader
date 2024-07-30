<?php

namespace App\Providers;

use App\Application\Interfaces\DocumentLoaderInterface;
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Interfaces\{DocumentRepositoryInterface, SettingRepositoryInterface};
use App\Infrastructure\Interfaces\HttpClientInterface;
use App\Infrastructure\Repositories\Document\DatabaseDocumentRepository;
use App\Infrastructure\Repositories\DocumentSchema\FileSchemaRepository;
use App\Infrastructure\Repositories\Setting\DatabaseSettingRepository;
use App\Infrastructure\Utils\{DocumentLoaderService, LaravelHttpClient};
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        DocumentLoaderInterface::class => DocumentLoaderService::class,
        HttpClientInterface::class => LaravelHttpClient::class,
        SchemaRepositoryInterface::class => FileSchemaRepository::class,
        SettingRepositoryInterface::class => DatabaseSettingRepository::class,
        DocumentRepositoryInterface::class => DatabaseDocumentRepository::class,
    ];

    public function register(): void
    {
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
