<?php
declare(strict_types=1);

namespace TaxCore;

use DateTimeInterface;
use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Entities\ItemInterface;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

interface RequestMethods
{

    /**
     * @param ItemInterface[] $items
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponseBuilder
     */
    public function advanceSale(
        array        $items,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentified(
        array        $items,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount,
        string       $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponseBuilder
     */
    public function advanceSaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     */
    public function copySale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function copySaleBuyerIdentifiedBuilder(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     */
    public function copySaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function copySaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @return ResponseBuilder
     */
    public function normalSale(array $items): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $buyerId
     * @param string|null $buyerCostCenterId
     * @return ResponseBuilder
     */
    public function normalSaleBuyerAndCostCenterIdentified(
        array       $items,
        string      $buyerId,
        string|null $buyerCostCenterId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     * @return ResponsesBuilder
     */
    public function normalSaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     * @return ResponsesBuilder
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
        string            $buyerId
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponsesBuilder
     */
    public function normalSaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @return ResponsesBuilder
     */
    public function normalSaleWithClosingAdvanceSale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        TaxRateLabel      $taxRateLabel,
        float             $recievedAmount,
    ): ResponsesBuilder;
}
