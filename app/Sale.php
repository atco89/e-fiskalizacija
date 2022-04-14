<?php
declare(strict_types=1);

namespace TaxCore;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\Configuration;
use TaxCore\Entities\Merchant;
use TaxCore\Entities\RequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Sale extends Request
{

    /**
     * @param Merchant $merchant
     * @param Configuration $configuration
     */
    public function __construct(Merchant $merchant, Configuration $configuration)
    {
        parent::__construct($configuration);
    }

    /**
     * @param RequestInterface $request
     * @return string
     * @throws GuzzleException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TaxCoreRequestException
     */
    public function run(RequestInterface $request): string
    {
        $httpClient = new Client();
        $response = $httpClient->post($this->configuration->apiUrl(), $this->requestOptions($request));
        if ($response->getStatusCode() === 200) {
            $response = new Response(json_decode($response->getBody()->getContents()));
            return $this->document($request, $response);
        }
        throw new TaxCoreRequestException();
    }

    /**
     * @param RequestInterface $request
     * @param Response $response
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @noinspection PhpUnhandledExceptionInspection
     */
    private function document(RequestInterface $request, Response $response): string
    {
        $document = new Document($request, $response);
        return $document->generate();
    }
}
