<?php
declare(strict_types=1);

namespace TaxCore;

use DateTimeInterface;
use GuzzleHttp\RequestOptions;
use TaxCore\Entities\BuyerCostCenterInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\Request\AdvanceSale\AdvanceSaleRequest;

abstract class RequestBuilder
{

    /**
     * @const string
     */
    const DATE_TIME_FORMAT = DateTimeInterface::ISO8601;

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
            $this->configuration->password(),
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
        $props = [
            'invoiceType'            => $request->invoiceType()->value,
            'transactionType'        => $request->transactionType()->value,
            'invoiceNumber'          => $this->configuration->esdcNumber(),
            'cashier'                => $this->configuration->cashier(),
            'referentDocumentNumber' => $this->loadReferentDocumentNumber($request),
            'referentDocumentDT'     => $this->loadReferentDocumentDateTime($request),
            'items'                  => $this->buildItems($request->items()),
            'payment'                => $this->buildPayment($request->payments()),
            'options'                => $this->buildOptions(),
        ];

        if ($request instanceof AdvanceSaleRequest) {
            $props['dateAndTimeOfIssue'] = $request->issueDateTime()->format(self::DATE_TIME_FORMAT);
        }

        if ($request instanceof BuyerInterface) {
            $props['buyerId'] = $this->loadBuyerId($request);
        }

        if ($request instanceof BuyerCostCenterInterface) {
            $buyerCostCenterId = $this->loadBuyerCostCenterId($request);
            if (!empty($buyerCostCenterId)) {
                $props['buyerCostCenterId'] = $buyerCostCenterId;
            }
        }

        return $props;
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
            ? $request->referentDocumentDateTime()->format(self::DATE_TIME_FORMAT)
            : null;
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

    /**
     * @param PaymentTypeInterface[] $payments
     * @return array
     */
    private function buildPayment(array $payments): array
    {
        return array_map(function (PaymentTypeInterface $payment): array {
            return [
                'paymentType' => $payment->type(),
                'amount'      => $payment->amount(),
            ];
        }, $payments);
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
        return $request instanceof BuyerCostCenterInterface ? $request->buyerCostCenterId() : null;
    }
}
