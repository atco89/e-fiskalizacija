<?php
declare(strict_types=1);

namespace Fiskalizacija\Entities;

use Fiskalizacija\Enums\CashierDisplayType;

abstract class Configuration
{

    /**
     * @const string
     */
    const APPLICATION_JSON = 'application/json';

    /**
     * @return CashierDisplayType
     */
    abstract public function cashierDisplayType(): CashierDisplayType;

    /**
     * @return Merchant
     */
    abstract public function merchant(): Merchant;

    /**
     * @return string
     */
    abstract public function merchantLogoPath(): string;

    /**
     * @return string
     */
    abstract public function apiUrl(): string;

    /**
     * @param string $requestId
     * @return string[]
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    final public function headers(string $requestId): array
    {
        return [
            'Accept'          => Configuration::APPLICATION_JSON,
            'Content-Type'    => Configuration::APPLICATION_JSON,
            'RequestId'       => $requestId,
            'Accept-Language' => $this->language(),
            'PAC'             => $this->pac(),
        ];
    }

    /**
     * @return string
     */
    abstract protected function language(): string;

    /**
     * @return string
     */
    abstract protected function pac(): string;

    /**
     * @return string[]
     */
    final public function certs(): array
    {
        return [$this->certPath(), $this->password()];
    }

    /**
     * @return string
     */
    abstract protected function certPath(): string;

    /**
     * @return string
     */
    abstract protected function password(): string;
}
