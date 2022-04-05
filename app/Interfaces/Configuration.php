<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

abstract class Configuration
{

    /**
     * @param string $requestId
     * @param array $requestBody
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    final public function options(string $requestId, array $requestBody): array
    {
        return [
            CURLOPT_URL           => $this->apiUrl(),
            CURLOPT_HTTPHEADER    => $this->headers($requestId),
            CURLOPT_POST          => true,
            CURLOPT_SSLCERTTYPE   => 'P12',
            CURLOPT_SSLCERT       => $this->certPath(),
            CURLOPT_SSLCERTPASSWD => $this->password(),
            CURLOPT_POSTFIELDS    => $requestBody,
        ];
    }

    /**
     * @return string
     */
    private function apiUrl(): string
    {
        return 'https://vsdc.sandbox.taxcore.online/api/v3/invoices';
    }

    /**
     * @return string
     */
    abstract protected function certPath(): string;

    /**
     * @return string
     */
    abstract protected function sslKey(): string;

    /**
     * @return string
     */
    abstract protected function password(): string;

    /**
     * @param string $requestId
     * @return string[]
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    private function headers(string $requestId): array
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
}
