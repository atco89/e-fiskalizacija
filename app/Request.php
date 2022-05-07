<?php
declare(strict_types=1);

namespace TaxCore;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\Request\RequestCustomerIdentifiedPropertiesInterface;
use TaxCore\Entities\Request\RequestCustomerIdentifiedWithCostCenterPropertiesInterface;
use TaxCore\Entities\Request\RequestPropertiesInterface;
use TaxCore\Entities\Request\RequestRefundCustomerIdentifiedPropertiesInterface;
use TaxCore\Entities\Request\RequestRefundPropertiesInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentPropertiesInterface;
use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleBuyerIdentified;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleBuyerIdentifiedRefund;
use TaxCore\Request\AdvanceSale\RequestAdvanceSaleRefund;
use TaxCore\Request\AdvanceSale\RequestAdvanceSale;
use TaxCore\Request\CopySale\RequestCopySaleBuyerIdentified;
use TaxCore\Request\CopySale\RequestCopySaleBuyerIdentifiedRefund;
use TaxCore\Request\CopySale\RequestCopySaleRefund;
use TaxCore\Request\CopySale\RequestCopySale;
use TaxCore\Request\NormalSale\RequestNormalSaleBuyerAndCostCenterIdentified;
use TaxCore\Request\NormalSale\RequestNormalSaleBuyerIdentifiedRefund;
use TaxCore\Request\NormalSale\RequestNormalSaleRefund;
use TaxCore\Request\NormalSale\RequestNormalSale;
use TaxCore\Request\NormalSale\RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale;
use TaxCore\Request\NormalSale\RequestNormalSaleWithClosingAdvanceSale;
use TaxCore\Response\Response;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Twig\Twig;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Request extends RequestBuilder
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
     * @param RequestPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(RequestPropertiesInterface $properties): ResponseBuilder
    {
        $request = new RequestNormalSale($properties);
        return $this->run($request);
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
     * @param RequestCustomerIdentifiedWithCostCenterPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleCustomerIdentified(
        RequestCustomerIdentifiedWithCostCenterPropertiesInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestNormalSaleBuyerAndCostCenterIdentified($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(RequestRefundPropertiesInterface $properties): ResponseBuilder
    {
        $request = new RequestNormalSaleRefund($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundCustomerIdentifiedPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefundCustomerIdentified(
        RequestRefundCustomerIdentifiedPropertiesInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestNormalSaleBuyerIdentifiedRefund($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundCustomerIdentifiedPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefundCustomerIdentified(
        RequestRefundCustomerIdentifiedPropertiesInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestAdvanceSaleBuyerIdentifiedRefund($properties);
        return $this->run($request);
    }

    /**
     * @param RequestPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSale(RequestPropertiesInterface $properties): ResponseBuilder
    {
        $request = new RequestAdvanceSale($properties);
        return $this->run($request);
    }

    /**
     * @param RequestCustomerIdentifiedPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleCustomerIdentified(
        RequestCustomerIdentifiedPropertiesInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestAdvanceSaleBuyerIdentified($properties);
        return $this->run($request);
    }

    /**
     * @param RequestWithReferentDocumentPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySale(RequestWithReferentDocumentPropertiesInterface $properties): ResponseBuilder
    {
        $request = new RequestCopySale($properties);
        return $this->run($request);
    }

    /**
     * @param RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleCustomerIdentified(
        RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestCopySaleBuyerIdentified($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefund(
        RequestRefundPropertiesInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestCopySaleRefund($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundCustomerIdentifiedPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefundCustomerIdentified(
        RequestRefundCustomerIdentifiedPropertiesInterface $properties
    ): ResponseBuilder
    {
        $request = new RequestCopySaleBuyerIdentifiedRefund($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundPropertiesInterface $requestRefund
     * @param RequestPropertiesInterface $requestSale
     * @return ResponseBuilder[]
     * @throws TaxCoreRequestException
     */
    public function normalSaleWithClosedAdvanceSaleRequest(
        RequestRefundPropertiesInterface $requestRefund,
        RequestPropertiesInterface       $requestSale
    ): array
    {
        $advanceSaleRefundResponseBuilder = $this->advanceSaleRefund($requestRefund);
        return [
            $advanceSaleRefundResponseBuilder,
            $this->run(new RequestNormalSaleWithClosingAdvanceSale(
                $requestSale,
                $advanceSaleRefundResponseBuilder->getResponse()
            )),
        ];
    }

    /**
     * @param RequestRefundPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefund(RequestRefundPropertiesInterface $properties): ResponseBuilder
    {
        $request = new RequestAdvanceSaleRefund($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundCustomerIdentifiedPropertiesInterface $refundProperties
     * @param RequestCustomerIdentifiedPropertiesInterface $saleProperties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleWithClosedAdvanceSaleCustomerIdentifiedRequest(
        RequestRefundCustomerIdentifiedPropertiesInterface $refundProperties,
        RequestCustomerIdentifiedPropertiesInterface       $saleProperties
    ): ResponseBuilder
    {
        $response = $this->advanceSaleRefund($refundProperties)->getResponse();
        $request = new RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale($saleProperties, $response);
        return $this->run($request);
    }
}
