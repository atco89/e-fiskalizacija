<?php
declare(strict_types=1);

namespace TaxCore;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request\NormalSale\NormalSale;
use TaxCore\Request\NormalSale\NormalSaleCustomerIdentified;
use TaxCore\Request\NormalSale\NormalSaleRefund;
use TaxCore\Request\NormalSale\NormalSaleRefundCustomerIdentified;
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
     * @param string $invoiceNumber
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(string $cashier, string $invoiceNumber, array $items, array $payment): ResponseBuilder
    {
        return $this->run(new NormalSale($cashier, $invoiceNumber, $items, $payment));
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
     * @param string $invoiceNumber
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleCustomerIdentified(
        string         $cashier,
        string         $invoiceNumber,
        array          $items,
        array          $payment,
        BuyerInterface $buyer
    ): ResponseBuilder
    {
        return $this->run(new NormalSaleCustomerIdentified(
            $cashier,
            $invoiceNumber,
            $items,
            $payment,
            $buyer
        ));
    }

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(
        string                    $cashier,
        string                    $invoiceNumber,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument
    ): ResponseBuilder
    {
        return $this->run(new NormalSaleRefund($cashier, $invoiceNumber, $items, $payment, $referentDocument));
    }

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefundCustomerIdentified(
        string                    $cashier,
        string                    $invoiceNumber,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    ): ResponseBuilder
    {
        return $this->run(new NormalSaleRefundCustomerIdentified(
            $cashier,
            $invoiceNumber,
            $items,
            $payment,
            $referentDocument,
            $buyer
        ));
    }
}
