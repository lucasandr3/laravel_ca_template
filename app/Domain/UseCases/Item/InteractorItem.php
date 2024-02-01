<?php

namespace App\Domain\UseCases\Item;

use App\Domain\Interfaces\PregaoEletronico\GetDataItems;
use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Events\Item\AtualizaItemEvent;
use App\Events\Item\SalvarItemEvent;
use App\Factories\PregaoEletronico\ItemModelFactory;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class InteractorItem
{
    public function __construct
    (
        private readonly ProcessRepository $processRepository,
        private readonly GetDataProcess $getDataProcess,
        private readonly GetDataItems $getDataItems,
        private readonly SystemParams $systemParams,
        private readonly ItemModelFactory $factory,
        private readonly HttpService $httpService,
        private readonly ItemOutput $output
    )
    {}

    public function getAllItems(InputItemRequest $input)
    {
        $compraMicroservico = $this->processRepository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundPurchaseResource();
        }

        $parameters = $this->systemParams->itemParams(new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial
        ]));

        $result = $this->httpService->get($parameters);

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->error($result?->getBody()->getContents());
        }

        return $this->output->itens($result?->getBody()->getContents());
    }

    public function updateItems(InputItemRequest $input)
    {
        $compraMicroservico = $this->processRepository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundPurchaseResource();
        }

        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());

        if ($externalProcess === null) {
            return $this->output->notFoundExternalResource();
        }

        $externalItems = $this->getDataItems->getItemsByProcess($input->getCodProcess());
        $itemsPncp = $this->getAllItems($input);

        if ($itemsPncp->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->error($itemsPncp->getContent());
        }

        $codesItemsPncp = array_column(json_decode($itemsPncp->getContent()), 'numeroItem');
        $itemsToRegister = new Collection([]);

        foreach ($externalItems as $itemLicitanet) {
            if (in_array($itemLicitanet->id, $codesItemsPncp)) {
                $this->updateOneItem(new InputItemRequest([
                    'codProcesso' => $externalProcess->id,
                    'codItem' => $itemLicitanet->id
                ]));
            } else {
                $itemsToRegister->push($itemLicitanet);
            }
        }

        if ($itemsToRegister->isNotEmpty()) {
            $this->sendItems($itemsToRegister, $externalProcess->id, $compraMicroservico);
        }

        return $this->output->success();
    }

    private function sendItems($items, $codProcesso, $compraMicroservico)
    {
        $externalProcess = $this->getDataProcess->getProcessById($codProcesso);
        $itemToSend = $this->factory->make($items);

        $parameters = $this->systemParams->itemParams(new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial,
        ]), post: true);

        $data = [
            'body' => $itemToSend,
            'endpoint' => $parameters
        ];

        $result = $this->httpService->post($data, true);

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->error($result?->getBody()->getContents());
        }

        $dadosCompra = new Fluent([
            'externalProcess' => $externalProcess,
            'itensCompra' => $itemToSend,
        ]);

        event(new SalvarItemEvent($dadosCompra));
        return $this->output->created();
    }

    public function updateOneItem(InputItemRequest $input)
    {
        $compraMicroservico = $this->processRepository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundPurchaseResource();
        }

        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());

        if ($externalProcess === null) {
            return $this->output->notFoundExternalResource();
        }

        $externalItem = new Collection([$this->getDataItems->getItemsByID($input->getCodItem(), $input->getCodProcess())]);
        $itemData = $this->factory->make($externalItem);

        $parameters = $this->systemParams->itemParams(new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial,
            'sequencialItem' => current($itemData->getItems())['numeroItem']
        ]), true);

        $dataToUpdate = [
            'endpoint' => $parameters,
            'body' => current($itemData->getItems())
        ];

        $result = $this->httpService->put($dataToUpdate);

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->error($result?->getBody()->getContents());
        }

        $dadosCompra = new Fluent([
            'compra' => $compraMicroservico,
            'externalProcess' => $externalProcess,
            'item' => current($itemData->getItems())
        ]);

        event(new AtualizaItemEvent($dadosCompra));
        return $this->output->success();
    }

    private function updateItemResult(InputItemRequest $input)
    {
        $compraMicroservico = $this->processRepository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundPurchaseResource();
        }

        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());

        if ($externalProcess === null) {
            return $this->output->notFoundExternalResource();
        }

        $externalItem = new Collection([$this->getDataItems->getItemsByID($input->getCodItem(), $input->getCodProcess())]);
        $itemData = $this->factory->make($externalItem);

        $parameters = $this->systemParams->itemParams(new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial,
            'sequencialItem' => current($itemData->getItems())['numeroItem']
        ]), result: true);

        $dataToUpdate = [
            'endpoint' => $parameters,
            'body' => current($itemData->getItems())
        ];

        $result = $this->httpService->post($dataToUpdate, true);

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->error($result?->getBody()->getContents());
        }

        return $this->output->successPostResult();
    }

    public function sendResult(InputItemRequest $input)
    {
        $compraMicroservico = $this->processRepository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundPurchaseResource();
        }

        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());

        if ($externalProcess === null) {
            return $this->output->notFoundExternalResource();
        }

        $externalItems = $this->getDataItems->getItemsByProcess($input->getCodProcess());
        $homogationDate = $this->getDataProcess->getHomologationDate($input->getCodProcess(), CONFIG_EXTRATO_HOMOLOGADO);

        if ($homogationDate === null) {
            return $this->output->error(json_encode(['message' => 'Processo não está homologado']));
        }

        foreach ($externalItems as $item) {
            $lote = $this->getDataItems->getLoteDoItem($input->getCodProcess(), $item->cod_lote);
            $empresaVencedora = $this->getDataItems->getVencedorDoLote($lote->cod_vencedor);

            if (!$empresaVencedora) {
                $this->updateOneItem(new InputItemRequest([
                    'codProcesso' => $externalProcess->id,
                    'codItem' => $item->id
                ]));
                continue;
            }

            $this->updateItemResult($input);

            $parameters = $this->systemParams->itemParams(new Fluent([
                'cnpj' => $compraMicroservico->cnpj_entidade,
                'ano' => $compraMicroservico->ano,
                'sequencial' => $compraMicroservico->sequencial,
                'sequencialItem' => $item->id
            ]), result: true);

            $data = $this->getPurchaseItemResult($item, $process, $batch, $homologationDate);
            $purchaseItem = $item->purchaseItem();

            if (!empty($purchaseItem->sequencial_resultado)) {
                $endpoint = $params['HOST_PNCP'] . sprintf($params['LINK_PUT_RESULTADO'], $administration->cnpj, $purchase->ano, $purchase->sequencial, $item->id, $purchaseItem->sequencial_resultado);
                #validar se justificativa é obrigatório
                $response = Helpers::request(CONFIG_REST_PUT, $endpoint, [
                    'headers' => ['Authorization' => $authorization],
                    'json' => $data
                ]);
            } else {
                $response = Helpers::request(CONFIG_REST_POST, $endpoint, [
                    'headers' => ['Authorization' => $authorization],
                    'json' => $data
                ]);
            }

            if (!in_array($response->getStatusCode(), [STATUS_CODE_OK, STATUS_CODE_CREATED])) {
                $this->requestLogService->saveLogImp($response, CONFIG_CONSUMER_CADASTRAR_RESULTADO, $processId, $data);
            } else {
                $data['homologationDate'] = $homologationDate;
                $this->purchaseItemService->updatePurchaseItem($response, $authorization, $purchaseItem, $data);
            }
        }













//        $itemsPncp = $this->getAllItems($input);
//
//        if ($itemsPncp->getStatusCode() !== Response::HTTP_OK) {
//            return $this->output->error($itemsPncp->getContent());
//        }
//
//        $codesItemsPncp = array_column(json_decode($itemsPncp->getContent()), 'numeroItem');
//        $itemsToRegister = new Collection([]);
//
//        foreach ($externalItems as $itemLicitanet) {
//            if (in_array($itemLicitanet->id, $codesItemsPncp)) {
//                $this->updateOneItem(new InputItemRequest([
//                    'codProcesso' => $externalProcess->id,
//                    'codItem' => $itemLicitanet->id
//                ]));
//            } else {
//                $itemsToRegister->push($itemLicitanet);
//            }
//        }
//
//        if ($itemsToRegister->isNotEmpty()) {
//            $this->sendItems($itemsToRegister, $externalProcess->id, $compraMicroservico);
//        }
//
//        return $this->output->success();
    }

    private function getPurchaseItemResult(Item $item, Process $process, Batch $batch, string $homologationDate): array
    {
        $winningCompany = $batch->winner();
        $winningBid = $batch->winningBid();

        $quantity = Helpers::formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $item->quantidade, '.', '');

        if ($process->cod_tipo_pregao == CONFIG_JULGAMENTO_MENOR_I) {
            $unityValue = Helpers::formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $winningBid->valor, '.', '');

            $totalValue = bcmul($quantity, $winningBid->valor, CONFIG_MONETARIO_PRECISAO);
        } else {
            $unityValue = $item->valor_final ?? ($winningBid->valor / $quantity);
            $unityValue = Helpers::formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $unityValue, '.', '');

            $totalValue = bcmul($item->quantidade, $unityValue, CONFIG_MONETARIO_PRECISAO);
        }

        $totalValue = Helpers::formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $totalValue, '.', '');

        $porteFornecedor = $winningCompany->framing() === null
            ? CONFIG_PORTE_NAO_INFORMADO
            : $this->getFramingCompanyImp($winningCompany->framing()->sigla);

        return [
            "quantidadeHomologada" => $quantity,
            "valorUnitarioHomologado" => $unityValue,
            "valorTotalHomologado" => $totalValue,
            "percentualDesconto" => $item->valor_orcado > 0 ? $this->getPercent($item) : floatval(0),
            "porteFornecedorId" => $porteFornecedor,
            "codigoPais" => CONFIG_ISO_BRASIL,
            "tipoPessoaId" => (!$winningCompany->cnpj ? CONFIG_PESSOA_FISICA : CONFIG_PESSOA_JURIDICA),
            "niFornecedor" => (!$winningCompany->cnpj ? $winningCompany->num_cpf : $winningCompany->cnpj),
            "nomeRazaoSocialFornecedor" => $winningCompany->nome,
            "indicadorSubcontratacao" => CONFIG_INDICADOR_SUBCONTRATACAO_NAO,
            "ordemClassificacaoSrp" => 1,
            "dataResultado" => $homologationDate,
            'situacaoCompraItemResultadoId' => $this->getPurchaseItemResultSituationImp($batch->status()->nome),
//            "dataCancelamento" => null, #preencher se cancelado
//            "motivoCancelamento" => null, #preencher se cancelado
//            "justificativa" => null, #preencher se cancelado
        ];
    }
}
