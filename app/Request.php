<?php
declare(strict_types=1);

namespace TaxCore;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request\AdvanceSale\AdvanceSale;
use TaxCore\Request\AdvanceSale\AdvanceSaleCustomerIdentified;
use TaxCore\Request\AdvanceSale\AdvanceSaleRefund;
use TaxCore\Request\AdvanceSale\AdvanceSaleRefundCustomerIdentified;
use TaxCore\Request\CopySale\CopySale;
use TaxCore\Request\CopySale\CopySaleCustomerIdentified;
use TaxCore\Request\CopySale\CopySaleRefund;
use TaxCore\Request\CopySale\CopySaleRefundCustomerIdentified;
use TaxCore\Request\NormalSale\NormalSale;
use TaxCore\Request\NormalSale\NormalSaleCloseAdvanceSale;
use TaxCore\Request\NormalSale\NormalSaleCloseAdvanceSaleCustomerIdentified;
use TaxCore\Request\NormalSale\NormalSaleCustomerIdentified;
use TaxCore\Request\NormalSale\NormalSaleRefund;
use TaxCore\Request\NormalSale\NormalSaleRefundCustomerIdentified;
use TaxCore\Request\NormalSale\ReferentDocument\ReferentDocument;
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
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(string $cashier, array $items, array $payment): ResponseBuilder
    {
        $request = new NormalSale($cashier, $items, $payment);
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
            $client = new Client();
            $clientResponse = $client->post($this->configuration->apiUrl(), $this->requestOptions($request));
            $response = new Response(json_decode($clientResponse->getBody()->getContents()));
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
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleCustomerIdentified(
        string         $cashier,
        array          $items,
        array          $payment,
        BuyerInterface $buyer
    ): ResponseBuilder
    {
        $request = new NormalSaleCustomerIdentified($cashier, $items, $payment, $buyer);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument
    ): ResponseBuilder
    {
        $request = new NormalSaleRefund($cashier, $items, $payment, $referentDocument);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefundCustomerIdentified(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    ): ResponseBuilder
    {
        $request = new NormalSaleRefundCustomerIdentified($cashier, $items, $payment, $referentDocument, $buyer);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $advanceSaleReferentDocument
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleCloseAdvanceSale(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $advanceSaleReferentDocument,
    ): ResponseBuilder
    {
        $response = $this->advanceSaleRefund($cashier, $items, $payment, $advanceSaleReferentDocument);
        $referentDocument = new ReferentDocument($response->getResponse());
        $request = new NormalSaleCloseAdvanceSale($cashier, $items, $payment, $referentDocument);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefund(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
    ): ResponseBuilder
    {
        $request = new AdvanceSaleRefund($cashier, $items, $payment, $referentDocument);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $advanceSaleReferentDocument
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleCloseAdvanceSaleCustomerIdentified(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $advanceSaleReferentDocument,
        BuyerInterface            $buyer,
    ): ResponseBuilder
    {
        $response = $this->advanceSaleRefundCustomerIdentified(
            $cashier,
            $items,
            $payment,
            $advanceSaleReferentDocument,
            $buyer
        );
        $referentDocument = new ReferentDocument($response->getResponse());
        $request = new NormalSaleCloseAdvanceSaleCustomerIdentified(
            $cashier,
            $items,
            $payment,
            $buyer,
            $referentDocument
        );
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefundCustomerIdentified(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    ): ResponseBuilder
    {
        $request = new AdvanceSaleRefundCustomerIdentified($cashier, $items, $payment, $referentDocument, $buyer);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSale(string $cashier, array $items, array $payment): ResponseBuilder
    {
        $request = new AdvanceSale($cashier, $items, $payment);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleCustomerIdentified(
        string         $cashier,
        array          $items,
        array          $payment,
        BuyerInterface $buyer
    ): ResponseBuilder
    {
        $request = new AdvanceSaleCustomerIdentified($cashier, $items, $payment, $buyer);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySale(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
    ): ResponseBuilder
    {
        $request = new CopySale($cashier, $items, $payment, $referentDocument);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleCustomerIdentified(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    ): ResponseBuilder
    {
        $request = new CopySaleCustomerIdentified($cashier, $items, $payment, $buyer, $referentDocument);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefund(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument
    ): ResponseBuilder
    {
        $request = new CopySaleRefund($cashier, $items, $payment, $referentDocument);
        return $this->run($request);
    }

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefundCustomerIdentified(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    ): ResponseBuilder
    {
        $request = new CopySaleRefundCustomerIdentified($cashier, $items, $payment, $referentDocument, $buyer);
        return $this->run($request);
    }
}
