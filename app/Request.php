<?php
declare(strict_types=1);

namespace TaxCore;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Twig\Twig;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Request extends RequestBuilder
{

    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        parent::__construct($configuration);
        $this->twig = new Twig();
    }

    /**
     * @param RequestInterface $request
     * @return Response
     * @throws TaxCoreRequestException
     */
    public function run(RequestInterface $request): Response
    {
        try {
            $httpClient = new Client();
            $httpResponse = $httpClient->post($this->configuration->apiUrl(), $this->requestOptions($request));
            $response = new ResponseBuilder(json_decode($httpResponse->getBody()->getContents()));
            return $this->document($request, $response);
        } catch (LoaderError | RuntimeError | SyntaxError | GuzzleException | Exception | Throwable $e) {
            throw new TaxCoreRequestException($e->getMessage());
        }
    }

    /**
     * @param RequestInterface $request
     * @param ResponseBuilder $response
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function document(RequestInterface $request, ResponseBuilder $response): Response
    {
        $configuration = $this->configuration;
        $environment = $this->twig->getEnvironment();
        return new Response($configuration, $environment, $request, $response);
    }
}
