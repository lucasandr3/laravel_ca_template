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
use App\Repositories\Item\ItemRepository;
use App\Shared\Interfaces\GetDataCompany;
use App\Shared\Interfaces\GetDataStatus;
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
        private readonly GetDataCompany $dataCompany,
        private readonly GetDataStatus $dataStatus,
        private readonly ItemRepository $repository,
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
        ]), item: true);

        $dataToUpdate = [
            'endpoint' => $parameters,
            'body' => current($itemData->getItems())
        ];

        $result = $this->httpService->put($dataToUpdate);

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
        $homologationDate = $this->getDataProcess->getHomologationDate($input->getCodProcess(), CONFIG_EXTRATO_HOMOLOGADO);

        if ($homologationDate === null) {
            return $this->output->error(json_encode(['message' => 'Processo não está homologado']));
        }

        foreach ($externalItems as $item) {
            $lote = $this->getDataItems->getLoteDoItem($input->getCodProcess(), $item->cod_lote);

            if ($lote->cod_vencedor === null) {
                continue;
            }

            $empresaVencedora = $this->getDataItems->getVencedorDoLote($lote->cod_vencedor);
            $this->updateOneItem(new InputItemRequest([
                    'codProcesso' => $externalProcess->id,
                    'codItem' => $item->id
                ]));


            $this->updateItemResult(new InputItemRequest([
                'codItem' => $item->id,
                'codProcesso' => $externalProcess->id
            ]));

            $dataResultadoItem = $this->getPurchaseItemResult($item, $externalProcess, $lote, $empresaVencedora, $homologationDate);
            $itemMicroservico = $this->repository->getItemById($item->id);

            if (!empty($itemMicroservico->sequencial_resultado)) {

                $parameters = $this->systemParams->itemParams(new Fluent([
                    'cnpj' => $compraMicroservico->cnpj_entidade,
                    'ano' => $compraMicroservico->ano,
                    'sequencial' => $compraMicroservico->sequencial,
                    'sequencialItem' => $item->id,
                    'sequencialResultado' => $itemMicroservico->sequencial_resultado
                ]), result: true);

                $dataToUpdate = [
                    'body' => $dataResultadoItem,
                    'endpoint' => $parameters
                ];

                $result = $this->httpService->put($dataToUpdate);

            } else {
                $parameters = $this->systemParams->itemParams(new Fluent([
                    'cnpj' => $compraMicroservico->cnpj_entidade,
                    'ano' => $compraMicroservico->ano,
                    'sequencial' => $compraMicroservico->sequencial,
                    'sequencialItem' => $item->id
                ]), result: true);

                $dataToPost = [
                    'body' => $dataResultadoItem,
                    'endpoint' => $parameters,
                ];

                $result = $this->httpService->post($dataToPost, true);
            }

            if (!in_array($result?->getStatusCode(), [Response::HTTP_OK, Response::HTTP_CREATED])) {
                return $this->output->error($result?->getBody()->getContents());
            }

            $novoSequencialResultado = $this->getPurchaseResultUrlImp(current($result?->getHeader('location')));

            if ($novoSequencialResultado?->getStatusCode() !== Response::HTTP_OK) {
                return $this->output->error($novoSequencialResultado?->getBody()->getContents());
            }

            $resultado = json_decode($novoSequencialResultado?->getBody()->getContents());

            $dataResultadoItem['homologationDate'] = $homologationDate->dat_registro->format('Y-m-d');
            $dataResultadoItem['sequencialResultado'] = $resultado->sequencialResultado;

            $dataPurchaseItem = new Fluent([
                'compra' => $compraMicroservico,
                'externalProcess' => $externalProcess,
                'data' => $dataResultadoItem,
                'response' => $result?->getHeader('location'),
                'item' => $itemMicroservico
            ]);

            event(new AtualizaItemEvent($dataPurchaseItem));
        }

        return $this->output->successPostResult();
    }

    private function getPurchaseItemResult($item, $externalProcess, $lote, $empresaVencedora, $homologationDate): array
    {
        $porteEmpresaVencedora = $this->dataCompany->getPorteFornecedor($empresaVencedora->cod_enquadramento);
        $lanceVencedor = $this->dataCompany->getLanceVencedor($lote->cod_lance_vencedor);
        $status = $this->dataStatus->getStatusById($lote->cod_status);

        $quantity = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $item->quantidade, '.', '');

        if ($externalProcess->cod_tipo_pregao == CONFIG_JULGAMENTO_MENOR_I) {
            $unityValue = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $lanceVencedor->valor, '.', '');

            $totalValue = bcmul($quantity, $lanceVencedor->valor, CONFIG_MONETARIO_PRECISAO);
        } else {
            $unityValue = $item->valor_final ?? ($lanceVencedor->valor / $quantity);
            $unityValue = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $unityValue, '.', '');

            $totalValue = bcmul($item->quantidade, $unityValue, CONFIG_MONETARIO_PRECISAO);
        }

        $totalValue = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $totalValue, '.', '');

        $porteFornecedor = $porteEmpresaVencedora === null
            ? CONFIG_PORTE_NAO_INFORMADO
            : getFramingCompanyImp($porteEmpresaVencedora->sigla);

        return [
            "quantidadeHomologada" => $quantity,
            "valorUnitarioHomologado" => $unityValue,
            "valorTotalHomologado" => $totalValue,
            "percentualDesconto" => $item->valor_orcado > 0 ? $this->getPercent($externalProcess, $lanceVencedor, $item) : 0.0,
            "porteFornecedorId" => $porteFornecedor,
            "codigoPais" => CONFIG_ISO_BRASIL,
            "tipoPessoaId" => (!$empresaVencedora->cnpj ? CONFIG_PESSOA_FISICA : CONFIG_PESSOA_JURIDICA),
            "niFornecedor" => (!$empresaVencedora->cnpj ? $empresaVencedora->num_cpf : $empresaVencedora->cnpj),
            "nomeRazaoSocialFornecedor" => $empresaVencedora->nome,
            "indicadorSubcontratacao" => CONFIG_INDICADOR_SUBCONTRATACAO_NAO,
            "ordemClassificacaoSrp" => 1,
            "dataResultado" => $homologationDate->dat_registro->format('Y-m-d'),
            'situacaoCompraItemResultadoId' => getPurchaseItemResultSituationImp($status->nome),
//            "dataCancelamento" => null, #preencher se cancelado
//            "motivoCancelamento" => null, #preencher se cancelado
//            "justificativa" => null, #preencher se cancelado
        ];
    }

    private function getPercent($externalProcess, $lanceVencedor, $item): float
    {
        $maiorValor = in_array($externalProcess->cod_tipo_pregao, [
            CONFIG_JULGAMENTO_MAIOR_D,
            CONFIG_JULGAMENTO_MAIOR_L,
            CONFIG_JULGAMENTO_MAIOR_DL,
            CONFIG_JULGAMENTO_MAIOR_P
        ]);

        $lanceVenc = $lanceVencedor->valor;
        $value = $item->valor_final ?? ($lanceVenc / $item->quantidade);

        $economy = $maiorValor ?
            ($value - $item->valor_orcado) / $item->valor_orcado * 100 :
            ($item->valor_orcado - $value) / $item->valor_orcado * 100;

        return formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $economy, '.', '');
    }

    private function getPurchaseResultUrlImp(string $url)
    {
        return $this->httpService->get($url);
    }
}
