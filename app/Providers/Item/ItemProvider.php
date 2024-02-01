<?php

namespace App\Providers\Item;

use App\Adapters\Presenters\Item\ItemJsonPresenter;
use App\Domain\UseCases\Item\ItemOutput;
use Illuminate\Support\ServiceProvider;

class ItemProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ItemOutput::class,
            ItemJsonPresenter::class
        );

//        $this->app->bind(GetExternalDocument::class, ExternalDocument::class);
//
//        $this->app->bind(
//            ArquivoRepository::class,
//            ArquivoCompraRepository::class,
//        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
