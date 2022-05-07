<?php
declare(strict_types=1);

namespace TaxCore\Response;

final class ResponsesBuilder
{

    /**
     * @var ResponseBuilder
     */
    protected ResponseBuilder $firstInvoice;

    /**
     * @var ResponseBuilder
     */
    protected ResponseBuilder $secondInvoice;

    /**
     * @param ResponseBuilder $advanceSale
     * @param ResponseBuilder $normalSale
     */
    public function __construct(ResponseBuilder $advanceSale, ResponseBuilder $normalSale)
    {
        $this->firstInvoice = $advanceSale;
        $this->secondInvoice = $normalSale;
    }

    /**
     * @return ResponseBuilder
     */
    public function getFirstInvoice(): ResponseBuilder
    {
        return $this->firstInvoice;
    }

    /**
     * @return ResponseBuilder
     */
    public function getSecondInvoice(): ResponseBuilder
    {
        return $this->secondInvoice;
    }
}
