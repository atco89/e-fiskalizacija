<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use Fiskalizacija\Sale\Response;

final class Merchant
{

    /**
     * @var string
     */
    private string $taxIdentificationNumber;

    /**
     * @var string
     */
    private string $businessName;

    /**
     * @var string
     */
    private string $locationName;

    /**
     * @var string
     */
    private string $address;

    /**
     * @var string
     */
    private string $district;

    /**
     * @param Response $response
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(Response $response)
    {
        $this->businessName = $response->businessName();
        $this->taxIdentificationNumber = $response->tin();
        $this->locationName = $response->locationName();
        $this->address = $response->address();
        $this->district = $response->district();
    }

    /**
     * @return string
     */
    public function getTaxIdentificationNumber(): string
    {
        return $this->taxIdentificationNumber;
    }

    /**
     * @return string
     */
    public function getBusinessName(): string
    {
        return $this->businessName;
    }

    /**
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->locationName;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }
}
