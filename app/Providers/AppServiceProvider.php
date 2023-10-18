<?php

namespace App\Providers;

use App\Adapters\Presenters\CreateProcessJsonPresenter;
use App\Domain\Interfaces\Pregao\GetDataItems;
use App\Domain\Interfaces\Pregao\GetDataProcess;
use App\Domain\Interfaces\Pregao\ProcessFactory;
use App\Domain\Interfaces\Pregao\ProcessRepository;
use App\Domain\UseCases\Pregao\CreateProcessOutputPort;
use App\Factories\Pregao\ProcessModelFactory;
use App\Infra\Database\Repositories\External\Items\ExternalItems;
use App\Infra\Database\Repositories\External\Process\ExternalProcess;
use App\Infra\Database\Repositories\Pregao\ProcessDatabaseRepository;
use App\Infra\Services\ItemService;
use App\Infra\Services\ProcessService;
use App\Shared\Interfaces\GetItemsProcess;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Shared\Interfaces\GetDataProcess::class, ProcessService::class);
        $this->app->bind(GetItemsProcess::class, ItemService::class);

        $this->app->bind(
            ProcessFactory::class,
            ProcessModelFactory::class,
        );

        $this->app->bind(
            ProcessRepository::class,
            ProcessDatabaseRepository::class,
        );

        $this->app->bind(
            CreateProcessOutputPort::class,
            CreateProcessJsonPresenter::class
        );

        $this->app->bind(GetDataProcess::class, ExternalProcess::class);
        $this->app->bind(GetDataItems::class, ExternalItems::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
