<?php

namespace App\Providers;

use App\Adapters\Presenters\PregaoEletronico\CreateProcessJsonPresenter;
use App\Domain\Interfaces\PregaoEletronico\GetDataItems;
use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Domain\Interfaces\PregaoEletronico\ProcessFactory;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Domain\UseCases\PregaoEletronico\PregaoEletronicoOutput;
use App\Factories\PregaoEletronico\ProcessModelFactory;
use App\Infra\Database\Repositories\External\Items\ExternalItems;
use App\Infra\Database\Repositories\External\Process\ExternalProcess;
use App\Infra\Database\Repositories\PregaoEletronico\ProcessDatabaseRepository;
use App\Infra\Services\ItemService;
use App\Infra\Services\ProcessService;
use App\Repositories\Fornecedor\FornecedorRepository;
use App\Repositories\PregaoEletronico\PregaoEletronicoRepository;
use App\Repositories\Status\StatusRepository;
use App\Shared\Factories\ProcessToDatabase;
use App\Shared\Interfaces\GetDataCompany;
use App\Shared\Interfaces\GetDataStatus;
use App\Shared\Interfaces\GetItemsProcess;
use App\Shared\Interfaces\ProcessToDatabaseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProcessToDatabaseFactory::class, ProcessToDatabase::class);
        $this->app->bind(\App\Shared\Interfaces\GetDataProcess::class, ProcessService::class);
        $this->app->bind(GetItemsProcess::class, ItemService::class);

        $this->app->bind(
            ProcessFactory::class,
            ProcessModelFactory::class,
        );

        $this->app->bind(
            ProcessRepository::class,
            PregaoEletronicoRepository::class,
        );

        $this->app->bind(
            PregaoEletronicoOutput::class,
            CreateProcessJsonPresenter::class
        );

        $this->app->bind(GetDataProcess::class, ExternalProcess::class);
        $this->app->bind(GetDataItems::class, ExternalItems::class);

        $this->app->bind(GetDataCompany::class, FornecedorRepository::class);
        $this->app->bind(GetDataStatus::class, StatusRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
