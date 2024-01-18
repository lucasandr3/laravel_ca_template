<?php

namespace App\Providers\Unidade;

use App\Adapters\Presenters\Unidade\UnidadeJsonPresenter;
use App\Domain\Interfaces\Unidade\UnidadeRepositoryInterface;
use App\Domain\UseCases\Unidade\UnidadeOutput;
use App\Repositories\Unidade\UnidadeRepository;
use Illuminate\Support\ServiceProvider;

class UnidadeProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UnidadeRepositoryInterface::class, UnidadeRepository::class);

        $this->app->bind(
            UnidadeOutput::class,
            UnidadeJsonPresenter::class
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
