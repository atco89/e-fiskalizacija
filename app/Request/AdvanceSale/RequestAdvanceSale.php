<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use DateTime;
use DateTimeInterface;
use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Request\AdvanceSaleBuilder;

final class RequestAdvanceSale extends AdvanceSaleBuilder
{

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $issueDateTime;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     */
    public function __construct(array $items, array $payment, TaxRateLabel $taxRateLabel, float $recievedAmount)
    {
        $this->issueDateTime = $this->generateIssueDateTime();
        parent::__construct($items, $payment, $taxRateLabel, $recievedAmount);
    }

    /**
     * @return DateTimeInterface
     */
    protected function generateIssueDateTime(): DateTimeInterface
    {
        return new DateTime();
    }

    /**
     * @return DateTimeInterface|null
     */
    public function issueDateTime(): DateTimeInterface|null
    {
        return $this->issueDateTime;
    }
}
