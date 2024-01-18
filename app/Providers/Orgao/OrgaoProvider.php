<?php

namespace App\Providers\Orgao;

use App\Adapters\Presenters\Orgao\OrgaoJsonPresenter;
use App\Domain\UseCases\Orgao\OrgaoOutput;
use Illuminate\Support\ServiceProvider;

class OrgaoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            OrgaoOutput::class,
            OrgaoJsonPresenter::class
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
