<?php
declare(strict_types=1);

namespace TaxCore;

use DateTime;
use GuzzleHttp\RequestOptions;
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
        return [
            'dateAndTimeOfIssue'     => $request->issueDateTime()->format(DATE_ISO8601),
            'cashier'                => $request->cashier()->id(),
            'buyerId'                => $request->buyerId(),
            'buyerCostCenterId'      => $request->buyerCostCenterId(),
            'invoiceType'            => $request->invoiceType()->value,
            'transactionType'        => $request->transactionType()->value,
            'payment'                => $this->formatPayments($request->payments()),
            'invoiceNumber'          => $request->invoiceNumber(),
            'referentDocumentNumber' => $request->referentDocumentNumber(),
            'referentDocumentDT'     => $this->loadReferentDocumentDateTime($request->referentDocumentDateTime()),
            'options'                => $this->options(),
            'items'                  => $this->formatItems($request->items()),
        ];
    }

    /**
     * @param Payment[] $payments
     * @return array
     */
    private function formatPayments(array $payments): array
    {
        return array_map(function (Payment $payment): array {
            return [
                'paymentType' => $payment->type(),
                'amount'      => $payment->amount(),
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
