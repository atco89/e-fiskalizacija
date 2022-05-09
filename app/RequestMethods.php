<?php
declare(strict_types=1);

namespace TaxCore;

use DateTimeInterface;
use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

interface RequestMethods
{

    /**
     * @param ItemInterface[] $items
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @return ResponseBuilder
     */
    public function advanceSale(array $items, array $advanceSaleItems): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param array $advanceSaleItems
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentified(
        array  $items,
        array  $advanceSaleItems,
        string $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @return ResponseBuilder
     */
    public function advanceSaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems
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
     * @param string $buyerId
     * @return ResponseBuilder
     */
    public function copySaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
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
     * @return ResponseBuilder
     */
    public function normalSaleBuyerIdentifiedRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @param string $buyerId
     * @return ResponsesBuilder
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
        string            $buyerId
    ): ResponsesBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @return ResponseBuilder
     */
    public function normalSaleRefund(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    ): ResponseBuilder;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @return ResponsesBuilder
     */
    public function normalSaleWithClosingAdvanceSale(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
    ): ResponsesBuilder;
}
