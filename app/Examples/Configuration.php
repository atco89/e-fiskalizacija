<?php
declare(strict_types=1);

namespace TaxCore\Examples;

use TaxCore\Entities\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{

    /**
     * @return string
     */
    public function logoPath(): string
    {
        return __DIR__ . '/../../resources/assets/logo.png';
    }

    /**
     * @return string
     */
    public function apiUrl(): string
    {
        return 'http://devesdc.sandbox.suf.purs.gov.rs:8888/086ccb88-6b35-4f98-b9ed-29863dcc1b9b/api/v3/invoices';
    }

    /**
     * @return string
     */
    public function language(): string
    {
        return 'sr-Cyrl-RS';
    }

    /**
     * @return string
     */
    public function pac(): string
    {
        return 'WMPSA4';
    }

    /**
     * @return string
     */
    public function certPath(): string
    {
        return __DIR__ . '/../../resources/cert/cert.pfx';
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return '6DLQUGVV';
    }

    /**
     * @return string
     */
    public function esdcNumber(): string
    {
        return '923/v1.0';
    }

    /**
     * @return string
     */
    public function cashier(): string
    {
        return 'Petar Petrović';
    }
}
