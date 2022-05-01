<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\Sale;

final class AdvanceSaleCustomer extends Sale implements BuyerInterface
{

    /**
     * @var array
     */
    private array $buyer;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param array $buyer
     */
    public function __construct(string $cashier, array $items, array $payment, array $buyer)
    {
        parent::__construct($cashier, $items, $payment);
        $this->buyer = $buyer;
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyer['buyerId'];
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return $this->buyer['buyerCostCenterId'];
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }
}
