<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;

final class NormalSaleCustomerIdentified extends CommonRequest implements BuyerInterface
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
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }

    /**
     * @return TransactionType
     */
    public function transactionType(): TransactionType
    {
        return TransactionType::SALE;
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
}
