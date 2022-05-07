<?php
declare(strict_types=1);

namespace TaxCore;

use TaxCore\Entities\Request\RequestBuyerAndCostCenterIdentifiedInterface;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;
use TaxCore\Entities\Request\RequestInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentBuyerIdentifiedInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

interface RequestMethods
{

    /**
     * @param RequestInterface $request
     * @return ResponseBuilder
     */
    public function advanceSale(RequestInterface $request): ResponseBuilder;

    /**
     * @param RequestBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentified(RequestBuyerIdentifiedInterface $request): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     */
    public function advanceSaleBuyerIdentifiedRefund(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request
    ): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     */
    public function advanceSaleRefund(RequestWithReferentDocumentInterface $request): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     */
    public function copySale(RequestWithReferentDocumentInterface $request): ResponseBuilder;

    /**
     * @param $request
     * @return ResponseBuilder
     */
    public function copySaleBuyerIdentifiedBuilder($request): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     */
    public function copySaleRefund(RequestWithReferentDocumentInterface $request): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     */
    public function copySaleRefundBuyerIdentified(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request
    ): ResponseBuilder;

    /**
     * @param RequestInterface $request
     * @return ResponseBuilder
     */
    public function normalSale(RequestInterface $request): ResponseBuilder;

    /**
     * @param RequestBuyerAndCostCenterIdentifiedInterface $request
     * @return ResponseBuilder
     */
    public function normalSaleBuyerAndCostCenterIdentified(
        RequestBuyerAndCostCenterIdentifiedInterface $request
    ): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @return ResponseBuilder
     */
    public function normalSaleBuyerIdentifiedRefund(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request
    ): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $requestRefund
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $requestSale
     * @return ResponsesBuilder
     */
    public function normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        RequestWithReferentDocumentBuyerIdentifiedInterface $requestRefund,
        RequestWithReferentDocumentBuyerIdentifiedInterface $requestSale
    ): ResponsesBuilder;

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @return ResponseBuilder
     */
    public function normalSaleRefund(RequestWithReferentDocumentInterface $request): ResponseBuilder;

    /**
     * @param RequestWithReferentDocumentInterface $requestRefund
     * @param RequestWithReferentDocumentInterface $requestSale
     * @return ResponsesBuilder
     */
    public function normalSaleWithClosingAdvanceSale(
        RequestWithReferentDocumentInterface $requestRefund,
        RequestWithReferentDocumentInterface $requestSale
    ): ResponsesBuilder;
}
