<?php
declare(strict_types=1);

namespace TaxCore;

use DateTimeInterface;
use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

interface RequestMethods
{

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponseBuilder
     */
    public function advanceSale(
        array        $items,
        array        $payment,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentified(
        array        $items,
        array        $payment,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount,
        string       $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentifiedRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponseBuilder
     */
    public function advanceSaleRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     */
    public function copySale(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function copySaleBuyerIdentifiedBuilder(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     */
    public function copySaleRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function copySaleBuyerIdentifiedRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @return ResponseBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSale(
        array $items,
        array $payment
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $buyerId
     * @param string|null $buyerCostCenterId
     * @return ResponseBuilder
     */
    public function normalSaleBuyerAndCostCenterIdentified(
        array       $items,
        array       $payment,
        string      $buyerId,
        string|null $buyerCostCenterId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponsesBuilder
     */
    public function normalSaleBuyerIdentifiedRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponsesBuilder
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
        string            $buyerId
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponsesBuilder
     * @throws TaxCoreRequestException
     */
    public function normalSaleRefund(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponsesBuilder
     */
    public function normalSaleWithClosingAdvanceSale(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
    ): ResponsesBuilder;
}
