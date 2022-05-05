<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TaxLabel;
use TaxCore\Request\AdvanceSale\Item\AdvanceSaleItem;
use TaxCore\Request\SaleCustomerIdentified;

final class AdvanceSaleCustomerIdentified extends SaleCustomerIdentified
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }

    /**
     * @return array
     * @noinspection DuplicatedCode
     */
    public function items(): array
    {
        $amounts = [
            TaxLabel::T0->value => 0.00,
            TaxLabel::T1->value => 0.00,
            TaxLabel::T2->value => 0.00,
        ];

        foreach ($this->items as $item) {
            if (in_array(TaxLabel::T0->value, $item->labels())) {
                $amounts[TaxLabel::T0->value] += $item->amount();
            } else if (in_array(TaxLabel::T1->value, $item->labels())) {
                $amounts[TaxLabel::T1->value] += $item->amount();
            } else if (in_array(TaxLabel::T2->value, $item->labels())) {
                $amounts[TaxLabel::T2->value] += $item->amount();
            }
        }

        $items = [];
        foreach ($amounts as $label => $amount) {
            $items[] = new AdvanceSaleItem($label, $amount);
        }

        return $items;
    }

    /**
     * @return array|null
     */
    public function advertisementItems(): array|null
    {
        return $this->items;
    }
}