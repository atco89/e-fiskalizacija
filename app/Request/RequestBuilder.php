<?php
declare(strict_types=1);

namespace TaxCore\Request;

use GuzzleHttp\RequestOptions;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\RequestInterface;

abstract class RequestBuilder
{

    /**
     * @var ConfigurationInterface
     */
    protected ConfigurationInterface $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    protected function requestOptions(RequestInterface $request): array
    {
        return [
            RequestOptions::CERT    => $this->cert(),
            RequestOptions::HEADERS => $this->headers($request->requestId()),
            RequestOptions::JSON    => $this->requestBody($request),
        ];
    }

    /**
     * @return array
     */
    private function cert(): array
    {
        return [
            $this->configuration->certPath(),
            $this->configuration->externalSalesDataControllerNumber(),
        ];
    }

    /**
     * @param string $requestId
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    private function headers(string $requestId): array
    {
        return [
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/json',
            'RequestId'       => $requestId,
            'Accept-Language' => $this->configuration->language(),
            'PAC'             => $this->configuration->pac(),
        ];
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    private function requestBody(RequestInterface $request): array
    {
        return [
            'dateAndTimeOfIssue'     => $request->issueDateTime()->format(DATE_ISO8601),
            'cashier'                => $request->cashier(),
            'buyerId'                => $this->loadBuyerId($request),
            'buyerCostCenterId'      => $this->loadBuyerCostCenterId($request),
            'invoiceType'            => $request->invoiceType()->value,
            'transactionType'        => $request->transactionType()->value,
            'payment'                => $this->buildPaymentTypes($request->payments()),
            'invoiceNumber'          => $request->invoiceNumber(),
            'referentDocumentNumber' => $this->loadReferentDocumentNumber($request),
            'referentDocumentDT'     => $this->loadReferentDocumentDateTime($request),
            'options'                => $this->buildOptions(),
            'items'                  => $this->buildItems($request->items()),
        ];
    }

    /**
     * @param RequestInterface $request
     * @return string|null
     */
    private function loadBuyerId(RequestInterface $request): string|null
    {
        return $request instanceof BuyerInterface ? $request->buyerId() : null;
    }

    /**
     * @param RequestInterface $request
     * @return string|null
     */
    private function loadBuyerCostCenterId(RequestInterface $request): string|null
    {
        return $request instanceof BuyerInterface ? $request->buyerCostCenterId() : null;
    }

    /**
     * @param PaymentTypeInterface[] $payments
     * @return array
     */
    private function buildPaymentTypes(array $payments): array
    {
        return array_map(function (PaymentTypeInterface $payment): array {
            return [
                'paymentType' => $payment->type(),
                'amount'      => $payment->amount(),
            ];
        }, $payments);
    }

    /**
     * @param RequestInterface $request
     * @return string|null
     */
    private function loadReferentDocumentNumber(RequestInterface $request): string|null
    {
        return $request instanceof ReferentDocumentInterface ? $request->referentDocumentNumber() : null;
    }

    /**
     * @param RequestInterface $request
     * @return string|null
     */
    private function loadReferentDocumentDateTime(RequestInterface $request): string|null
    {
        return $request instanceof ReferentDocumentInterface
            ? $request->referentDocumentDateTime()->format(DATE_ISO8601)
            : null;
    }

    /**
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    private function buildOptions(): array
    {
        return [
            'OmitQRCodeGen'             => 0,
            'OmitTextualRepresentation' => 1,
        ];
    }

    /**
     * @param array $items
     * @return array
     */
    private function buildItems(array $items): array
    {
        return array_map(function (ItemInterface $item): array {
            return [
                'gtin'        => $item->gtin(),
                'name'        => $item->name(),
                'quantity'    => $item->quantity(),
                'unitPrice'   => $item->unitPrice(),
                'labels'      => $item->labels(),
                'totalAmount' => $item->amount(),
            ];
        }, $items);
    }
}
