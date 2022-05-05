<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class RefundCustomerIdentified extends Refund implements BuyerInterface
{

    /**
     * @var BuyerInterface
     */
    protected BuyerInterface $buyer;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    )
    {
        parent::__construct($cashier, $items, $payment, $referentDocument);
        $this->buyer = $buyer;
    }

    /**
     * @return string
     */
    final public function buyerId(): string
    {
        return $this->buyer->buyerId();
    }

    /**
     * @return string|null
     */
    final public function buyerCostCenterId(): string|null
    {
        return $this->buyer->buyerCostCenterId();
    }
}
