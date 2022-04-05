<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

abstract class Configuration
{

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
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/json',
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
