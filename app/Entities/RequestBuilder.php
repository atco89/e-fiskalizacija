<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;
use GuzzleHttp\RequestOptions;

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
            'payment'                => $this->formatPayments($request->payments()->all()),
            'invoiceNumber'          => $request->invoiceNumber(),
            'referentDocumentNumber' => $request->referentDocumentNumber(),
            'referentDocumentDT'     => $this->buildReferentDocumentDateTime($request->referentDocumentDateTime()),
            'options'                => $this->options($request),
            'items'                  => $this->formatItems($request->items()->all()),
        ];
    }

    /**
     * @param array $payments
     * @return array
     */
    private function formatPayments(array $payments): array
    {
        return array_map(function (PaymentTypeInterface $payment): array {
            return [
                'paymentType' => $payment->type(),
                'amount'      => $payment->amount(),
            ];
        }, $payments);
    }

    /**
     * @param DateTime|null $refDocumentDateTime
     * @return string|null
     */
    private function buildReferentDocumentDateTime(?DateTime $refDocumentDateTime): ?string
    {
        return $refDocumentDateTime instanceof DateTime ? $refDocumentDateTime->format(DATE_ISO8601) : null;
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    private function options(RequestInterface $request): array
    {
        return [
            'OmitQRCodeGen'             => intval($request->omitQRCodeGen()),
            'OmitTextualRepresentation' => intval($request->omitTextualRepresentation()),
        ];
    }

    /**
     * @param array $items
     * @return array
     */
    private function formatItems(array $items): array
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
