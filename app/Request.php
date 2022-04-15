<?php
declare(strict_types=1);

namespace TaxCore;

use DateTime;
use GuzzleHttp\RequestOptions;
use TaxCore\Entities\Buyer;
use TaxCore\Entities\Configuration;
use TaxCore\Entities\Item;
use TaxCore\Entities\Payment;
use TaxCore\Entities\RequestInterface;

abstract class Request
{

    /**
     * @var Configuration
     */
    protected Configuration $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
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
            RequestOptions::HEADERS => $this->headers($request->invoice()->requestId()),
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
        return [
            'dateAndTimeOfIssue'     => $request->invoice()->issueDateTime()->format(DATE_ISO8601),
            'cashier'                => $request->cashier()->id(),
            'buyerId'                => $this->loadBuyerId($request->buyer()),
            'buyerCostCenterId'      => $this->loadBuyerCostCenterId($request->buyer()),
            'invoiceType'            => $request->invoice()->invoiceType()->value,
            'transactionType'        => $request->invoice()->transactionType()->value,
            'payment'                => $this->formatPayments($request->payments()),
            'invoiceNumber'          => $request->invoice()->invoiceNumber(),
            'referentDocumentNumber' => $request->invoice()->referentDocumentNumber(),
            'referentDocumentDT'     => $this->loadReferentDocumentDateTime($request->invoice()->referentDocumentDateTime()),
            'options'                => $this->options(),
            'items'                  => $this->formatItems($request->items()),
        ];
    }

    /**
     * @param Buyer|null $buyer
     * @return string|null
     */
    private function loadBuyerId(?Buyer $buyer): ?string
    {
        return $buyer instanceof Buyer ? $buyer->buyerId() : null;
    }

    /**
     * @param Buyer|null $buyer
     * @return string|null
     */
    private function loadBuyerCostCenterId(?Buyer $buyer): ?string
    {
        return $buyer instanceof Buyer ? $buyer->buyerCostCenterId() : null;
    }

    /**
     * @param Payment[] $payments
     * @return array
     */
    private function formatPayments(array $payments): array
    {
        return array_map(function (Payment $payment): array {
            return [
                'amount'      => $payment->amount(),
                'paymentType' => $payment->type(),
            ];
        }, $payments);
    }

    /**
     * @param DateTime|null $referentDocumentDateTime
     * @return string|null
     */
    private function loadReferentDocumentDateTime(?DateTime $referentDocumentDateTime): ?string
    {
        return $referentDocumentDateTime instanceof DateTime
            ? $referentDocumentDateTime->format(DATE_ISO8601)
            : null;
    }

    /**
     * @return int[]
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    private function options(): array
    {
        return [
            'OmitQRCodeGen'             => 0,
            'OmitTextualRepresentation' => 1,
        ];
    }

    /**
     * @param Item[] $items
     * @return array
     */
    private function formatItems(array $items): array
    {
        return array_map(function (Item $item): array {
            return [
                'gtin'        => $item->barcode(),
                'name'        => $item->name(),
                'quantity'    => $item->quantity(),
                'unitPrice'   => $item->unitPrice(),
                'labels'      => $item->labels(),
                'totalAmount' => $item->amount(),
            ];
        }, $items);
    }
}
