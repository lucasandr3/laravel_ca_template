<?php

namespace App\Providers\Arquivo;

use App\Adapters\Presenters\Arquivo\ArquivoJsonPresenter;
use App\Domain\Interfaces\Contrato\ArquivoRepository;
use App\Domain\UseCases\Arquivo\ArquivoOutput;
use App\Infra\Database\Repositories\External\Arquivo\ExternalDocument;
use App\Repositories\Arquivo\ArquivoCompraRepository;
use App\Shared\Interfaces\GetExternalDocument;
use Illuminate\Support\ServiceProvider;

class ArquivoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ArquivoOutput::class,
            ArquivoJsonPresenter::class
        );

        $this->app->bind(GetExternalDocument::class, ExternalDocument::class);

        $this->app->bind(
            ArquivoRepository::class,
            ArquivoCompraRepository::class,
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
