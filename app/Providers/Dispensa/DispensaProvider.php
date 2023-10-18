<?php

namespace App\Providers\Dispensa;

use App\Adapters\Presenters\Dispensa\DispensaJsonPresenter;
use App\Domain\Interfaces\Dispensa\DispensaFactoryInterface;
use App\Domain\Interfaces\Dispensa\DispensaRepositoryInterface;
use App\Domain\Interfaces\Dispensa\GetDataDispensa;
use App\Domain\UseCases\Dispensa\OutputPort;
use App\Factories\Dispensa\DispensaFactory;
use App\Infra\Database\Repositories\External\Process\ExternalProcess;
use App\Repositories\Dispensa\DispensaRepository;
use Illuminate\Support\ServiceProvider;

class DispensaProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            DispensaFactoryInterface::class,
            DispensaFactory::class,
        );

        $this->app->bind(
            DispensaRepositoryInterface::class,
            DispensaRepository::class,
        );

        $this->app->bind(
            OutputPort::class,
            DispensaJsonPresenter::class
        );

        $this->app->bind(GetDataDispensa::class, ExternalProcess::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
