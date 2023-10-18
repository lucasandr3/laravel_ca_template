<?php

namespace App\Http\Controllers\Dispensa;

use App\Adapters\ViewModels\JsonResourceModel;
use App\Domain\UseCases\Dispensa\DispensaInteractor;
use App\Domain\UseCases\Dispensa\InputDispensa;
use App\Http\Controllers\Controller;

class DispensaController extends Controller
{
    public function __construct(private DispensaInteractor $interactor)
    {}

    public function create(int $codProcess)
    {
        $response = $this->interactor->createProcess(new InputDispensa([], $codProcess));

        if ($response instanceof JsonResourceModel) {
            return $response->getResource();
        }

        return null;
    }

    public function delete(int $codProcess)
    {
        $response = $this->interactor->deleteProcess(new InputDispensa([], $codProcess));

        echo "<pre>"; var_dump($response); echo "</pre>"; die;
    }
}
