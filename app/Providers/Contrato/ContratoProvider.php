<?php

namespace App\Providers\Contrato;

use App\Adapters\Presenters\Contrato\ContratoJsonPresenter;
use App\Domain\Interfaces\Contrato\ContratoRepositoryInterface;
use App\Domain\UseCases\Contrato\ContratoOutput;
use App\Repositories\Contrato\ContratoRepository;
use Illuminate\Support\ServiceProvider;

class ContratoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ContratoRepositoryInterface::class, ContratoRepository::class);

        $this->app->bind(
            ContratoOutput::class,
            ContratoJsonPresenter::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
