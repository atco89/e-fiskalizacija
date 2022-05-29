<?php
declare(strict_types=1);

namespace TaxCore;

use DateTimeInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\Enums\PaymentType;
use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
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
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSale(
        array        $items,
        array        $payment,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSale($items, $payment, $taxRateLabel, $recievedAmount);
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
    private function buildResponse(
        ApiRequestInterface $request,
        Response            $response
    ): ResponseBuilder
    {
        $configuration = $this->configuration;
        $environment = $this->twig->getEnvironment();
        return new ResponseBuilder($configuration, $environment, $request, $response);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleBuyerIdentified(
        array        $items,
        array        $payment,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount,
        string       $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleBuyerIdentified(
            $items,
            $payment,
            $taxRateLabel,
            $recievedAmount,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySale(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySale(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleBuyerIdentifiedRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleBuyerIdentifiedRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(
        array $items,
        array $payment
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSale($items, $payment);
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $buyerId
     * @param string|null $buyerCostCenterId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleBuyerAndCostCenterIdentified(
        array       $items,
        array       $payment,
        string      $buyerId,
        string|null $buyerCostCenterId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestNormalSaleBuyerAndCostCenterIdentified(
            $items,
            $payment,
            $buyerId,
            $buyerCostCenterId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     * @throws Exception
     */
    public function normalSaleBuyerIdentifiedRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponsesBuilder
    {
        $normalSaleBuyerIdentifiedRefundResponseBuilder = $this->run(new RequestNormalSaleBuyerIdentifiedRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $buyerId
        ));

        $copySaleBuyerIdentifiedResponseBuilder = $this->copySaleBuyerIdentifiedBuilder(
            $items,
            $payment,
            $normalSaleBuyerIdentifiedRefundResponseBuilder->getResponse()->invoiceNumber(),
            $normalSaleBuyerIdentifiedRefundResponseBuilder->getResponse()->sdcDateTime(),
            $buyerId
        );

        return new ResponsesBuilder(
            $normalSaleBuyerIdentifiedRefundResponseBuilder,
            $copySaleBuyerIdentifiedResponseBuilder
        );
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleBuyerIdentifiedBuilder(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleBuyerIdentified(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     * @throws Exception
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
        string            $buyerId
    ): ResponsesBuilder
    {
        $advanceSaleResponseBuilder = $this->advanceSaleBuyerIdentifiedRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $taxRateLabel,
            $recievedAmount,
            $buyerId
        );

        $advanceSaleResponse = $advanceSaleResponseBuilder->getResponse();

        $normalSaleResponseBuilder = $this->run(new RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale(
            $items,
            $payment,
            $advanceSaleResponse->invoiceNumber(),
            $advanceSaleResponse->sdcDateTime(),
            $advanceSaleResponse->totalAmount(),
            $advanceSaleResponse->taxItems(),
            $buyerId
        ));
        return new ResponsesBuilder($advanceSaleResponseBuilder, $normalSaleResponseBuilder);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleBuyerIdentifiedRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
        string            $buyerId
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleBuyerIdentifiedRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $taxRateLabel,
            $recievedAmount,
            $buyerId
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     * @throws Exception
     */
    public function normalSaleRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponsesBuilder
    {
        $normalSaleRefundResponseBuilder = $this->run(new RequestNormalSaleRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
        ));
        $copySaleRefundResponseBuilder = $this->copySaleRefund(
            $items,
            $payment,
            $normalSaleRefundResponseBuilder->getResponse()->invoiceNumber(),
            $normalSaleRefundResponseBuilder->getResponse()->sdcDateTime(),
        );
        return new ResponsesBuilder($normalSaleRefundResponseBuilder, $copySaleRefundResponseBuilder);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function copySaleRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder
    {
        $serviceRequest = new RequestCopySaleRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime
        );
        return $this->run($serviceRequest);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     * @throws Exception
     */
    public function normalSaleWithClosingAdvanceSale(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
    ): ResponsesBuilder
    {
        $advanceSalePayment = [new class($recievedAmount) implements PaymentTypeInterface {

            /**
             * @var float
             */
            protected float $recievedAmount;

            /**
             * @param float $recievedAmount
             */
            public function __construct(float $recievedAmount)
            {
                $this->recievedAmount = $recievedAmount;
            }

            /**
             * @return PaymentType
             */
            public function type(): PaymentType
            {
                return PaymentType::CASH;
            }

            /**
             * @return string
             */
            public function name(): string
            {
                return 'Готовина';
            }

            /**
             * @return float
             */
            public function amount(): float
            {
                return $this->recievedAmount;
            }
        }];


        $advanceSaleResponseBuilder = $this->advanceSaleRefund(
            $items,
            $advanceSalePayment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $taxRateLabel,
            $recievedAmount
        );

        $advanceSaleResponse = $advanceSaleResponseBuilder->getResponse();

        $normalSaleResponseBuilder = $this->run(new RequestNormalSaleWithClosingAdvanceSale(
            $items,
            $payment,
            $advanceSaleResponse->invoiceNumber(),
            $advanceSaleResponse->sdcDateTime(),
            $advanceSaleResponse->totalAmount(),
            $advanceSaleResponse->taxItems(),
        ));
        return new ResponsesBuilder($advanceSaleResponseBuilder, $normalSaleResponseBuilder);
    }

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function advanceSaleRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
    ): ResponseBuilder
    {
        $serviceRequest = new RequestAdvanceSaleRefund(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $taxRateLabel,
            $recievedAmount
        );
        return $this->run($serviceRequest);
    }
}
