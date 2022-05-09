<?php
declare(strict_types=1);

namespace TaxCore;

use DateTimeInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request\AdvanceSale\RequestAdvanceSale;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleBuyerIdentified;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleBuyerIdentifiedRefund;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleRefund;
use TaxCore\Request\CopySale\RequestCopySale;
use TaxCore\Request\CopySale\RequestCopySaleBuyerIdentified;
use TaxCore\Request\CopySale\RequestCopySaleBuyerIdentifiedRefund;
use TaxCore\Request\CopySale\RequestCopySaleRefund;
use TaxCore\Request\NormalSale\RequestNormalSale;
use TaxCore\Request\NormalSale\RequestNormalSaleBuyerAndCostCenterIdentified;
use TaxCore\Request\NormalSale\RequestNormalSaleBuyerIdentifiedRefund;
use TaxCore\Request\NormalSale\RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale;
use TaxCore\Request\NormalSale\RequestNormalSaleRefund;
use TaxCore\Request\NormalSale\RequestNormalSaleWithClosingAdvanceSale;
use TaxCore\Response\Response;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;
use TaxCore\Twig\Twig;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Request extends RequestBuilder implements RequestMethods
{

    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        parent::__construct($configuration);
        $this->twig = new Twig();
    }

    /**
     * @param ApiRequestInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    private function run(ApiRequestInterface $request): ResponseBuilder
    {
        try {
            $httpClient = new Client();
            $httpClientResponse = $httpClient->post($this->configuration->apiUrl(), $this->requestOptions($request));
            $response = new Response(json_decode($httpClientResponse->getBody()->getContents()));
            return $this->buildResponse($request, $response);
        } catch (LoaderError | RuntimeError | SyntaxError | GuzzleException | Exception | Throwable $e) {
            throw new TaxCoreRequestException($e->getMessage());
        }
    }

    /**
     * @param ApiRequestInterface $request
     * @param Response $response
     * @return ResponseBuilder
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function buildResponse(ApiRequestInterface $request, Response $response): ResponseBuilder
    {
        $configuration = $this->configuration;
        $environment = $this->twig->getEnvironment();
        return new ResponseBuilder($configuration, $environment, $request, $response);
    }

    /**
     * @param ItemInterface[] $items
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSale(array $items, array $advanceSaleItems): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSale($items, $advanceSaleItems);
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param array $advanceSaleItems
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleBuyerIdentified(array $items, array $advanceSaleItems, string $buyerId): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleBuyerIdentified($items, $advanceSaleItems, $buyerId);
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleBuyerIdentifiedRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $advanceSaleItems,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $advanceSaleItems
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySale(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleBuyerIdentifiedBuilder(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleBuyerIdentified(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleBuyerIdentifiedRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(array $items): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSale($items);
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $buyerId
     * @param string|null $buyerCostCenterId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerAndCostCenterIdentified(
        array       $items,
        string      $buyerId,
        string|null $buyerCostCenterId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleBuyerAndCostCenterIdentified($items, $buyerId, $buyerCostCenterId);
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleBuyerIdentifiedRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @param string $buyerId
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
        string            $buyerId
    ): ResponsesBuilder
    {
        $advanceSaleResponseBuilder = $this->advanceSaleBuyerIdentifiedRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $advanceSaleItems,
            $buyerId
        );

        $advanceSaleResponse = $advanceSaleResponseBuilder->getResponse();
        $serviceRequest = new RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $advanceSaleResponse->totalAmount(),
            $advanceSaleResponse->taxItems(),
            $buyerId
        );

        $normalSaleResponseBuilder = $this->run($serviceRequest);
        return new ResponsesBuilder($advanceSaleResponseBuilder, $normalSaleResponseBuilder);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleWithClosingAdvanceSale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
    ): ResponsesBuilder
    {
        $advanceSaleResponseBuilder = $this->advanceSaleRefund(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $advanceSaleItems,
        );

        $advanceSaleResponse = $advanceSaleResponseBuilder->getResponse();
        $serviceRequest = new RequestNormalSaleWithClosingAdvanceSale(
            $items,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $advanceSaleResponse->totalAmount(),
            $advanceSaleResponse->taxItems(),
        );

        $normalSaleResponseBuilder = $this->run($serviceRequest);
        return new ResponsesBuilder($advanceSaleResponseBuilder, $normalSaleResponseBuilder);
    }
}
