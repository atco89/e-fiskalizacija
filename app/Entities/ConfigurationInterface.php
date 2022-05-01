<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface ConfigurationInterface
{

    /**
     * @return string
     */
    public function logoPath(): string;

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

    /**
     * @return string
     */
    public function externalSalesDataControllerNumber(): string;
}
