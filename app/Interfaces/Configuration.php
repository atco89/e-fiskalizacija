<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

abstract class Configuration
{

    /**
     * @return string
     */
    final public function apiUrl(): string
    {
        return 'https://vsdc.sandbox.taxcore.online/api/v3/invoices';
    }

    /**
     * @param string $requestId
     * @param array $requestBody
     * @return array
     */
    final public function options(string $requestId, array $requestBody): array
    {
        return [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_VERBOSE        => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSLCERTTYPE    => 'P12',
            CURLOPT_SSLCERT        => $this->certPath(),
            CURLOPT_SSLCERTPASSWD  => $this->password(),
            CURLOPT_HTTPHEADER     => $this->headers($requestId),
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $requestBody,
        ];
    }

    /**
     * @return string
     */
    abstract protected function certPath(): string;

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
