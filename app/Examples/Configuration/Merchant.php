<?php
declare(strict_types=1);

namespace TaxCore\Examples\Configuration;

use TaxCore\Entities\Enums\CashierDisplayType;
use TaxCore\Entities\MerchantInterface;

final class Merchant implements MerchantInterface
{

    /**
     * @return string
     */
    public function logoPath(): string
    {
        return __DIR__ . '/../../../resources/assets/logo.png';
    }

    /**
     * @return string
     */
    public function tin(): string
    {
        return '107830382';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'ОКОиОКО';
    }

    /**
     * @return string
     */
    public function branchName(): string
    {
        return 'ОКОиОКО';
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return 'Макензијева 20';
    }

    /**
     * @return string
     */
    public function district(): string
    {
        return 'Београд-Врачар';
    }

    /**
     * @return CashierDisplayType
     */
    public function cashierDisplayType(): CashierDisplayType
    {
        return CashierDisplayType::NAME_SURNAME;
    }
}
