<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class RefundCustomerIdentified extends Refund implements BuyerInterface
{

    /**
     * @var BuyerInterface
     */
    protected BuyerInterface $buyer;

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
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
}
