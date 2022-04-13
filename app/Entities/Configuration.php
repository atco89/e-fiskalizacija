<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Configuration extends Merchant
{

    /**
     * @return string
     */
    public function apiUrl(): string;

    /**
     * @return string
     */
    public function language(): string;

    /**
     * @return string
     */
    public function pac(): string;

    /**
     * @return string
     */
    public function certPath(): string;

    /**
     * @return string
     */
    public function password(): string;
}
