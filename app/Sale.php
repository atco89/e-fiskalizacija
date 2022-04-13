<?php
declare(strict_types=1);

namespace TaxCore;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
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
     * @var Twig
     */
    protected Twig $twig;

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
     * @return string
     * @throws GuzzleException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TaxCoreRequestException
     */
    public function run(RequestInterface $request): string
    {
        $client = new Client();
        $response = $client->post($this->configuration->apiUrl(), $this->requestOptions($request));
        if ($response->getStatusCode() === 200) {
            return $this->response($request, $response);
        }
        throw new TaxCoreRequestException();
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $responseInterface
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @noinspection PhpUnhandledExceptionInspection
     */
    private function response(
        RequestInterface  $request,
        ResponseInterface $responseInterface
    ): string
    {
        $response = new Response(json_decode($responseInterface->getBody()->getContents()));
        $properties = new DocumentProperties($request, $response);
        return $this->twig->getEnvironment()->render('./invoice/index.html.twig', ['properties' => $properties]);
    }
}
