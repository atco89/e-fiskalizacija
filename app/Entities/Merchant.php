<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Merchant
{

    /**
     * @return string
     */
    public function tin(): string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function branchName(): string;

    /**
     * @return string
     */
    public function address(): string;

    /**
     * @return string
     */
    public function district(): string;

    /**
     * @return CashierDisplayType
     */
    public function cashierDisplayType(): CashierDisplayType;
}
