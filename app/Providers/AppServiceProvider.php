<?php

namespace App\Providers;

use App\Adapters\Presenters\PregaoNovaLei\CreateProcessJsonPresenter;
use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessInputPort;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessInteractor;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessOutputPort;
use App\Factories\PregaoNovaLei\ProcessModelFactory;
use App\Http\Controllers\PregaoNovaLei\CreatePregaoNovaLeiController;
use App\Repositories\PregaoNovaLei\ProcessDatabaseRepository;
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

        $this->app
            ->when(CreatePregaoNovaLeiController::class)
            ->needs(CreateProcessInputPort::class)
            ->give(function ($app) {
                return $app->make(CreateProcessInteractor::class, [
                    'output' => $app->make(CreateProcessJsonPresenter::class),
                ]);
            });

//        $this->app->bind(
//            CreateProcessOutputPort::class,
//            CreateProcessJsonPresenter::class,
//        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
