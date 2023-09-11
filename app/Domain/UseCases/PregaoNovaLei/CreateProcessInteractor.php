<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;
use App\Domain\Interfaces\PregaoNovaLei\ViewModel;

class CreateProcessInteractor implements CreateProcessInputPort
{
    private $output;
    public function __construct(
         CreateProcessOutputPort $output,
        private ProcessRepository $repository,
        private ProcessFactory $factory,
    ) {
        $this->output = $output;
    }

    public function createProcess(CreateProcessRequestModel $request): ViewModel
    {
        $process = $this->factory->make([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
        ]);

        if ($this->repository->exists($process)) {
            return $this->output->processAlreadyExists(new CreateProcessResponseModel($process));
        }

//        try {
//            //$user = $this->repository->create($user, new PasswordValueObject($request->getPassword()));
//        } catch (\Exception $e) {
//            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($process), $e);
//        }
//
//        return $this->output->processCreated(
//            new CreateProcessResponseModel($process)
//        );
    }
}
