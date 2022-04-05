<?php
declare(strict_types=1);

namespace Fiskalizacija\Sale;

use DateTime;
use Fiskalizacija\Interfaces\Configuration;

abstract class Sale extends Request
{

    /**
     * @var Configuration
     */
    protected Configuration $configuration;

    /**
     * @param Configuration $configuration
     * @param string $requestUuid
     * @param string $invoiceNumber
     * @param DateTime $dateAndTimeOfIssue
     * @param array $items
     * @param array $payments
     * @param string $cashierId
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(
        Configuration $configuration,
        string        $requestUuid,
        string        $invoiceNumber,
        DateTime      $dateAndTimeOfIssue,
        array         $items,
        array         $payments,
        string        $cashierId
    )
    {
        parent::__construct($requestUuid, $invoiceNumber, $dateAndTimeOfIssue, $items, $payments, $cashierId);
        $this->configuration = $configuration;
    }

    /**
     * @return bool|string
     */
    public function run(): bool|string
    {
        $curl = curl_init($this->configuration->apiUrl());
        curl_setopt_array($curl, $this->configuration->options($this->requestUuid, $this->requestBody()));
        return curl_exec($curl);
    }
}
