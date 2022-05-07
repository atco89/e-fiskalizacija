<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use DateTime;
use DateTimeInterface;
use TaxCore\Entities\Request\RequestInterface;
use TaxCore\Request\AdvanceSaleBuilder;

final class RequestAdvanceSale extends AdvanceSaleBuilder
{

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $issueDateTime;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->issueDateTime = $this->generateIssueDateTime();
        parent::__construct($request);
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
