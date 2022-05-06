<?php
declare(strict_types=1);

namespace TaxCore;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\Properties\RequestCustomerIdentifiedPropertiesInterface;
use TaxCore\Entities\Properties\RequestCustomerIdentifiedWithCostCenterPropertiesInterface;
use TaxCore\Entities\Properties\RequestPropertiesInterface;
use TaxCore\Entities\Properties\RequestRefundCustomerIdentifiedPropertiesInterface;
use TaxCore\Entities\Properties\RequestRefundPropertiesInterface;
use TaxCore\Entities\Properties\RequestWithReferentDocumentProperties;
use TaxCore\Entities\Properties\RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request\AdvanceSale\AdvanceSaleCustomerIdentifiedRequest;
use TaxCore\Request\AdvanceSale\AdvanceSaleRefundCustomerIdentifiedRequest;
use TaxCore\Request\AdvanceSale\AdvanceSaleRefundRequest;
use TaxCore\Request\AdvanceSale\AdvanceSaleRequest;
use TaxCore\Request\CopySale\CopySaleCustomerIdentifiedRequest;
use TaxCore\Request\CopySale\CopySaleRefundCustomerIdentifiedRequest;
use TaxCore\Request\CopySale\CopySaleRefundRequest;
use TaxCore\Request\CopySale\CopySaleRequest;
use TaxCore\Request\NormalSale\NormalSaleCustomerIdentifiedRequest;
use TaxCore\Request\NormalSale\NormalSaleRefundCustomerIdentifiedRequest;
use TaxCore\Request\NormalSale\NormalSaleRefundRequest;
use TaxCore\Request\NormalSale\NormalSaleRequest;
use TaxCore\Request\NormalSale\NormalSaleWithClosedAdvanceSaleCustomerIdentifiedRequest;
use TaxCore\Request\NormalSale\NormalSaleWithClosedAdvanceSaleRequest;
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
        $request = new NormalSaleRequest($properties);
        return $this->run($request);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    private function run(RequestInterface $request): ResponseBuilder
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
     * @param RequestInterface $request
     * @param Response $response
     * @return ResponseBuilder
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function buildResponse(RequestInterface $request, Response $response): ResponseBuilder
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
        $request = new NormalSaleCustomerIdentifiedRequest($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(RequestRefundPropertiesInterface $properties): ResponseBuilder
    {
        $request = new NormalSaleRefundRequest($properties);
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
        $request = new NormalSaleRefundCustomerIdentifiedRequest($properties);
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
        $request = new AdvanceSaleRefundCustomerIdentifiedRequest($properties);
        return $this->run($request);
    }

    /**
     * @param RequestPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSale(RequestPropertiesInterface $properties): ResponseBuilder
    {
        $request = new AdvanceSaleRequest($properties);
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
        $request = new AdvanceSaleCustomerIdentifiedRequest($properties);
        return $this->run($request);
    }

    /**
     * @param RequestWithReferentDocumentProperties $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySale(RequestWithReferentDocumentProperties $properties): ResponseBuilder
    {
        $request = new CopySaleRequest($properties);
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
        $request = new CopySaleCustomerIdentifiedRequest($properties);
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
        $request = new CopySaleRefundRequest($properties);
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
        $request = new CopySaleRefundCustomerIdentifiedRequest($properties);
        return $this->run($request);
    }

    /**
     * @param RequestRefundPropertiesInterface $refundProperties
     * @param RequestPropertiesInterface $saleProperties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleWithClosedAdvanceSaleRequest(
        RequestRefundPropertiesInterface $refundProperties,
        RequestPropertiesInterface       $saleProperties
    ): ResponseBuilder
    {
        $response = $this->advanceSaleRefund($refundProperties)->getResponse();
        $request = new NormalSaleWithClosedAdvanceSaleRequest($saleProperties, $response);
        return $this->run($request);
    }

    /**
     * @param RequestRefundPropertiesInterface $properties
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefund(RequestRefundPropertiesInterface $properties): ResponseBuilder
    {
        $request = new AdvanceSaleRefundRequest($properties);
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
        $request = new NormalSaleWithClosedAdvanceSaleCustomerIdentifiedRequest($saleProperties, $response);
        return $this->run($request);
    }
}
