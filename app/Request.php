<?php
declare(strict_types=1);

namespace TaxCore;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\Request\RequestBuyerAndCostCenterIdentifiedInterface;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;
use TaxCore\Entities\Request\RequestInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentBuyerIdentifiedInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request\AdvanceSale\RequestAdvanceSale;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleBuyerIdentified;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleBuyerIdentifiedRefund;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleRefund;
use TaxCore\Request\CopySale\RequestCopySale;
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
     * @param RequestInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSale(RequestInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSale($request);
        return $this->run($serviceRequest);
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
     * @param RequestBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleBuyerIdentified(RequestBuyerIdentifiedInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleBuyerIdentified($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySale(RequestWithReferentDocumentInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestCopySale($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param $request
     * @return ResponseBuilder
     */
    public function copySaleBuyerIdentifiedBuilder($request): ResponseBuilder
    {
        // TODO: Implement copySaleBuyerIdentifiedBuilder() method.
    }

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefund(RequestWithReferentDocumentInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleRefund($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefundBuyerIdentified(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleBuyerIdentifiedRefund($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(RequestInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSale($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestBuyerAndCostCenterIdentifiedInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerAndCostCenterIdentified(
        RequestBuyerAndCostCenterIdentifiedInterface $request
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleBuyerAndCostCenterIdentified($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerIdentifiedRefund(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleBuyerIdentifiedRefund($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $requestRefund
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $requestSale
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        RequestWithReferentDocumentBuyerIdentifiedInterface $requestRefund,
        RequestWithReferentDocumentBuyerIdentifiedInterface $requestSale
    ): ResponsesBuilder
    {
        $responseBuilder = $this->advanceSaleBuyerIdentifiedRefund($requestRefund);
        $serviceRequest = new RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale(
            $requestSale,
            $responseBuilder->getResponse()
        );
        return new ResponsesBuilder($responseBuilder, $this->run($serviceRequest));
    }

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleBuyerIdentifiedRefund(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleBuyerIdentifiedRefund($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(RequestWithReferentDocumentInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleRefund($request);
        return $this->run($serviceRequest);
    }

    /**
     * @param RequestWithReferentDocumentInterface $requestRefund
     * @param RequestWithReferentDocumentInterface $requestSale
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleWithClosingAdvanceSale(
        RequestWithReferentDocumentInterface $requestRefund,
        RequestWithReferentDocumentInterface $requestSale
    ): ResponsesBuilder
    {
        $responseBuilder = $this->advanceSaleRefund($requestRefund);
        $serviceRequest = new RequestNormalSaleWithClosingAdvanceSale($requestSale, $responseBuilder->getResponse());
        return new ResponsesBuilder($responseBuilder, $this->run($serviceRequest));
    }

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefund(RequestWithReferentDocumentInterface $request): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleRefund($request);
        return $this->run($serviceRequest);
    }
}
