<?php
declare(strict_types=1);

namespace TaxCore;

use GuzzleHttp\RequestOptions;
use TaxCore\Entities\Configuration;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\Item;
use TaxCore\Entities\PaymentMethod;
use TaxCore\Entities\RequestInterface;

abstract class Request
{

    /**
     * @var Configuration
     */
    private Configuration $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param RequestInterface $invoice
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    protected function requestOptions(RequestInterface $invoice): array
    {
        return [
            RequestOptions::CERT    => $this->cert(),
            RequestOptions::HEADERS => $this->headers($invoice->requestId()),
            RequestOptions::JSON    => $this->requestBody($invoice),
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
     * @param RequestInterface $invoice
     * @return array
     */
    private function requestBody(RequestInterface $invoice): array
    {
        return [
            'dateAndTimeOfIssue'     => $invoice->issueDateTime()->format(DATE_ISO8601),
            'cashier'                => $invoice->cashier()->id(),
            'buyerId'                => $invoice->buyerId(),
            'buyerCostCenterId'      => $invoice->buyerCostCenterId(),
            'invoiceType'            => $this->invoiceType()->value,
            'transactionType'        => $this->transactionType()->value,
            'payment'                => $this->formatPayments($invoice->payments()),
            'invoiceNumber'          => $invoice->invoiceNumber(),
            'referentDocumentNumber' => $invoice->referentDocumentNumber(),
            'referentDocumentDT'     => $invoice->referentDocumentDateTime(),
            'options'                => $this->options(),
            'items'                  => $this->formatItems($invoice->items()),
        ];
    }

    /**
     * @return InvoiceType
     */
    abstract protected function invoiceType(): InvoiceType;

    /**
     * @return TransactionType
     */
    abstract protected function transactionType(): TransactionType;

    /**
     * @param PaymentMethod[] $payments
     * @return array
     */
    private function formatPayments(array $payments): array
    {
        return array_map(function (PaymentMethod $payment): array {
            return [
                'amount'      => $payment->amount(),
                'paymentType' => $payment->paymentType(),
            ];
        }, $payments);
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
