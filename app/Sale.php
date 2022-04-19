<?php
declare(strict_types=1);

namespace TaxCore;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\Configuration;
use TaxCore\Entities\Merchant;
use TaxCore\Entities\Request as RequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;

final class Sale extends Request
{

    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * @param Merchant $merchant
     * @param Configuration $configuration
     */
    public function __construct(Merchant $merchant, Configuration $configuration)
    {
        parent::__construct($configuration);
        $this->twig = new Twig($merchant);
    }

    /**
     * @param RequestInterface $request
     * @return Document
     * @throws GuzzleException
     * @throws TaxCoreRequestException
     */
    public function run(RequestInterface $request): Document
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
     * @return Document
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    private function document(RequestInterface $request, Response $response): Document
    {
        return new Document($this->twig->getEnvironment(), $request, $response);
    }
}
