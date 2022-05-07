<?php
declare(strict_types=1);

namespace TaxCore\Response;

final class ResponsesBuilder
{

    /**
     * @var ResponseBuilder
     */
    protected ResponseBuilder $advanceSale;

    /**
     * @var ResponseBuilder
     */
    protected ResponseBuilder $normalSale;

    /**
     * @param ResponseBuilder $advanceSale
     * @param ResponseBuilder $normalSale
     */
    public function __construct(ResponseBuilder $advanceSale, ResponseBuilder $normalSale)
    {
        $this->advanceSale = $advanceSale;
        $this->normalSale = $normalSale;
    }

    /**
     * @return ResponseBuilder
     */
    public function getAdvanceSale(): ResponseBuilder
    {
        return $this->advanceSale;
    }

    /**
     * @return ResponseBuilder
     */
    public function getNormalSale(): ResponseBuilder
    {
        return $this->normalSale;
    }
}
