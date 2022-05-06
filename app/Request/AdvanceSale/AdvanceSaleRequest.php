<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use DateTime;
use DateTimeInterface;
use TaxCore\Entities\Properties\RequestPropertiesInterface;
use TaxCore\Request\AdvanceSale;

final class AdvanceSaleRequest extends AdvanceSale
{

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $issueDateTime;

    /**
     * @param RequestPropertiesInterface $properties
     */
    public function __construct(RequestPropertiesInterface $properties)
    {
        parent::__construct($properties);
        $this->issueDateTime = $this->generateIssueDateTime();
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
