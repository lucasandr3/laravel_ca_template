<?php

namespace App\Providers;

use App\Events\Arquivo\AtualizaArquivoEvent;
use App\Events\Arquivo\SalvarArquivoEvent;
use App\Events\Contrato\ContratoErrorEvent;
use App\Events\Contrato\ContratoSuccessEvent;
use App\Events\Contrato\DeleteContratoEvent;
use App\Events\Item\AtualizaItemEvent;
use App\Events\Item\ExcluirItemEvent;
use App\Events\Item\SalvarItemEvent;
use App\Events\Processo\AtualizarProcessoEvent;
use App\Events\Processo\ExcluirProcessoEvent;
use App\Events\Processo\SalvarProcessoEvent;
use App\Events\TestEvent;
use App\Listeners\Arquivo\AtualizaArquivoListener;
use App\Listeners\Arquivo\SalvarArquivoListener;
use App\Listeners\Contrato\DeletaContrato;
use App\Listeners\Contrato\ErroContrato;
use App\Listeners\Contrato\SalvaContrato;
use App\Listeners\Item\AtualizaItemListener;
use App\Listeners\Item\ExcluirItensListener;
use App\Listeners\Item\SalvarItensListener;
use App\Listeners\Processo\AtualizarProcessoListener;
use App\Listeners\Processo\ExcluirProcessoListener;
use App\Listeners\Processo\SalvarProcessoListener;
use App\Listeners\TestEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ContratoSuccessEvent::class => [
            SalvaContrato::class
        ],
        DeleteContratoEvent::class => [
            DeletaContrato::class
        ],
        ContratoErrorEvent::class => [
            ErroContrato::class
        ],
        TestEvent::class => [
            TestEventListener::class
        ],
        SalvarProcessoEvent::class => [
            SalvarProcessoListener::class
        ],
        AtualizarProcessoEvent::class => [
            AtualizarProcessoListener::class
        ],
        ExcluirProcessoEvent::class => [
            ExcluirProcessoListener::class
        ],
        SalvarItemEvent::class => [
            SalvarItensListener::class
        ],
        AtualizaItemEvent::class => [
            AtualizaItemListener::class
        ],
        ExcluirItemEvent::class => [
            ExcluirItensListener::class
        ],
        SalvarArquivoEvent::class => [
            SalvarArquivoListener::class
        ],
        AtualizaArquivoEvent::class => [
            AtualizaArquivoListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
