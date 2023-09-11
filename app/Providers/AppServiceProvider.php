<?php

namespace App\Providers;

use App\Adapters\Presenters\CreateProcessJsonPresenter;
use App\Domain\Interfaces\PregaoNovaLei\GetDataProcess;
use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessOutputPort;
use App\Factories\PregaoNovaLei\ProcessModelFactory;
use App\Infra\Database\Repositories\External\Process\ExternalProcess;
use App\Infra\Database\Repositories\PregaoNovaLei\ProcessDatabaseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
