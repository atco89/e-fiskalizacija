<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use DateTime;
use DateTimeInterface;
use TaxCore\Request\AdvanceSaleBuilder;

final class RequestAdvanceSale extends AdvanceSaleBuilder
{

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $issueDateTime;

    /**
     * @param array $items
     * @param array $advanceSaleItems
     */
    public function __construct(array $items, array $advanceSaleItems)
    {
        $this->issueDateTime = $this->generateIssueDateTime();
        parent::__construct($items, $advanceSaleItems);
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
